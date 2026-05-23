<?php
define('BASE_PATH', rtrim(dirname($_SERVER['SCRIPT_NAME'], 2), '/'));

session_start();
require __DIR__ . '/../vendor/autoload.php';


if (file_exists(__DIR__ . '/../.env')) {
  Dotenv\Dotenv::createImmutable(__DIR__ . '/../')->load();
}

use Acme\RawgService;


$service = new RawgService($_ENV['RAWG_API_KEY'] ?? getenv('RAWG_API_KEY'));


// parse data from config
$config_raw = file_get_contents("../config/views.json");
$config = json_decode($config_raw, true);

$games_per_page = $config["games"]["games_per_page"] ?? 10;
$devs_per_page = $config["developers"]["devs_per_page"] ?? 10;
// return the results array OR an empty array
$games_with_params_return = $games_with_params['results'] ?? [];


$games_current_page = isset($_GET['cpage']) ? (int) $_GET['cpage'] : 1;
$games_list = $service->fetchData("games", array("page_size" => $games_per_page, "page" => $games_current_page));
// genres
$genres_list = $service->fetchData("genres", array("page_size" => $games_per_page, "page" => $games_current_page));


$games_list_results = $games_list['results'] ?? [];
$devs_list = $service->fetchData("developers", array("page_size" => $devs_per_page));
$_SESSION["session_games_list"] = $games_list_results;
$games_page_offset = ($games_current_page - 1) * $games_per_page;
$games_to_render = array_slice($_SESSION["session_games_list"], $games_page_offset, $games_per_page);

// view - favourites
$db = new PDO(
  'sqlite:' . __DIR__ . '/../database/admin_panel.db',
  options: [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
);

$statement = $db->query("SELECT * FROM games");
$favourites = $statement->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="./css/main.css">

  <title>RAWG Game Lister</title>

  <style>
    body {
      display: grid;
      grid-template-columns: 1fr 11fr;
      grid-template-rows: 11fr auto;
      min-height: 100vh;
    }

    nav {
      border-right: 1px solid rgba(0, 0, 0, .35);
      grid-row: 1/span 2;
      grid-column: 1;
    }

    footer {
      grid-column: 1 / span 2;
      grid-row: 2 / span 2;
      border-top: 1px solid var(--color-light);
      min-height: 50px;
    }
  </style>
</head>

<body>
  <!-- navbar component -->
  <?php
  include '../src/Navbar.php';
  $view = $_GET["view"] ?? "games";
  $search_results = $_GET['search'] ?? null;
  $filter_results = $_GET['filter'] ?? null;

  // CLEAN UP LATER
  // accessing local database - stores favourited games, returns just their rawg_id (equal to 'id' parameter coming directly from the RAWG API)
  function dbAccess()
  {
    $db = 'sqlite:' . __DIR__ . '/../database/admin_panel.db';

    $results = [];
    $db_connect = new PDO($db);

    foreach ($db_connect->query("SELECT * FROM games") as $row) {
      $results[] = $row['rawg_id'];
    }

    return $results;
  }

  $favourites_id = dbAccess();
  // CLEAN UP LATER
  
  ?>
  <!-- main content - right side of the page -->
  <main class="flex flex-col gap-2 p-2 bg-primary">
    <section class="container-main flex flex-col gap-4 items-center">
      <h2>
        <?php
        switch ($view) {
          case "games":
            echo ucfirst($view ?? $_GET["game"] ?? "Games");
            break;
          case "game_page":
            echo str_replace('-', ' ', ucwords($_GET["game"]));
            break;
          case "developers":
            echo ucfirst($view);
        }
        ?>

      </h2>
      <form method="GET">
        <?php
        foreach ($_GET as $p => $v):
          echo "<input type='hidden' name='$p' value='$v'>";
        endforeach;
        ?>
        <select name="filter" id="filter_genres">
          <option value="all" selected>All Genres</option>
          <?php
          foreach ($genres_list["results"] as $genre):
            echo "<option value='$genre[slug]'>$genre[name]</option>";
          endforeach;
          ?>
        </select>
        <button class="btn text-primary" type="submit">Filter</button>
      </form>
      <div class="content flex gap-5 justify-center">
        <?php

        $game_ids_unique = array_unique($favourites_id);
        if ($view === "games") {
          // handles user search queries
          if ($search_results) {
            $games_list = $service->fetchData(
              'games',
              ["search" => $search_results]
            );
            foreach ($games_list["results"] as $game):
              $is_in_favourites = in_array($game['id'], $game_ids_unique);
              include __DIR__ . '/../src/GameCard.php';
            endforeach;
          } else if ($filter_results) {
            $games_list = $service->fetchData('games', array("page_size" => $games_per_page, "page" => $games_current_page, "genres" => $filter_results));
            foreach ($games_list["results"] as $game):
              include __DIR__ . '/../src/GameCard.php';
            endforeach;
          }
          // check in the session storage for this variable - stores the results array from the api
          else if (isset($_SESSION["session_games_list"])) {
            foreach ($_SESSION["session_games_list"] as $game):
              $is_in_favourites = in_array($game['id'], $game_ids_unique);
              include __DIR__ . '/../src/GameCard.php';
            endforeach;
          }
        }

        if ($view === "developers") {
          if ($search_results) {
            $devs_list = $service->fetchData('developers', ["search" => $search_results]);
          }
          $devs_list_results = $devs_list['results'];
          foreach ($devs_list_results as $dev):
            include __DIR__ . '/../src/DeveloperCard.php';
          endforeach;
        }

        //game details page
        if ($view === "game_page") {
          include __DIR__ . '/../src/GamePage.php';
        }
        // favourites page - will be empty by default, populates as you add games to favourites  
        if ($view === "favourites") {
          foreach ($favourites as $game):
            $game['id'] = $game['rawg_id'];
            $is_in_favourites = true;
            include __DIR__ . '/../src/GameCard.php';
          endforeach;
        }

        // login/registration form, accessed via a button in the menu on the left
        if ($view === "login") {
          include __DIR__ . '/../src/LoginForm.php';
        }
        ?>
      </div>
      <!-- pagination - currently only works from the 'games' page -->
      <div class="pagination my-4 
      <?php if ($view !== "games")
        echo 'hidden' ?>">
          <!-- <a class="btn px-4 py-2 bg-light font-bold" href="?view=games&page_size=15&cpage=<?= $games_current_page - 1 ?>">&larr; Previous</a>
        <a class="btn px-4 py-2 bg-light font-bold" href="?view=games&page_size=15&cpage=<?= $games_current_page + 1 ?>">Next &rarr;</a> -->
        <a class="btn px-4 py-2 bg-light font-bold" href="?<?= htmlspecialchars($_SERVER['QUERY_STRING']) ?>&cpage=<?= $games_current_page - 1 ?>">&larr; Previous</a>
        <a class="btn px-4 py-2 bg-light font-bold" href="?<?= htmlspecialchars($_SERVER['QUERY_STRING']) ?>&cpage=<?= $games_current_page + 1 ?>">Next &rarr;</a>
      </div>
      <div class="loading-popup gap-2 items-center hidden">
        <span>Loading next page...</span>
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
          class="lucide lucide-loader-icon lucide-loader rotate">
          <path d="M12 2v4" />
          <path d="m16.2 7.8 2.9-2.9" />
          <path d="M18 12h4" />
          <path d="m16.2 16.2 2.9 2.9" />
          <path d="M12 18v4" />
          <path d="m4.9 19.1 2.9-2.9" />
          <path d="M2 12h4" />
          <path d="m4.9 4.9 2.9 2.9" />
        </svg>
      </div>
    </section>
  </main>
  <footer class="w-full flex gap-2 justify-center items-center bg-secondary">
    <span>2025-2026 Made by Łukasz Cena :</span><a class="font-medium underline" href="https://lcena.me"> lcena.me</a>
  </footer>
  <script defer type="module">
    // import { addToDatabase, removeFromDb } from '../public/js/connect-to-database.js'
    import { callDb } from '../public/js/connect-to-database.js'

    document.addEventListener('click', (event) => {
      const btnAdd = event.target.closest('.dbc')
      const btnRemove = event.target.closest('.dbr')
      if (!btnAdd && !btnRemove) return
      else if (btnAdd) {
        const btnAddId = btnAdd.dataset.id
        callDb("add", [btnAddId])
      } else if (btnRemove) {
        const btnRemoveId = btnRemove.dataset.id
        callDb("remove", [btnRemoveId])
      }
    })

  </script>
</body>

</html>
