<?php

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


$games_list = $service->fetchData("games", array("page_size" => $games_per_page, "page" => 1));

$games_list_results = $games_list['results'] ?? [];

$devs_list = $service->fetchData("developers", array("page_size" => $devs_per_page));


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
      grid-template-columns: 2fr 10fr;
      min-height: 100vh;
    }

    nav {
      border-right: 1px solid rgba(0, 0, 0, .35)
    }
  </style>
</head>

<body>
  <!-- navbar component -->
  <?php
  include '../src/Navbar.php';
  $view = $_GET["view"] ?? "games";
  $search_results = $_GET['search'] ?? null;

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

      <div class="content flex gap-5 justify-center">
        <?php
        // echo print_r($favourites);
        
        $game_ids_unique = array_unique($favourites_id);


        if ($view === "games") {
          // handles user search queries
          if ($search_results) {
            $games_list = $service->fetchData(
              'games',
              ["search" => urlencode($search_results)]
            );
          }
          $games_list_results = $games_list['results'];

          foreach ($games_list_results as $game):
            $is_in_favourites = in_array($game['id'], $game_ids_unique);
            include __DIR__ . '/../src/GameCard.php';
          endforeach;
          // include __DIR__ . '/../api/GetMoreGames_2.php';
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


        if ($view === "game_page") {
          include __DIR__ . '/../src/GamePage.php';
        }

        if ($view === "favourites") {
          foreach ($favourites as $game):
            include __DIR__ . '/../src/GameCard.php';
          endforeach;
        }
        ?>
      </div>
      <!-- only show the 'show more games' button when we're on the main page (where all games are displayed) -->
      <!-- later itll also show for favourites and developers -->
      <?php
      if ($view === 'games') {
        echo "<button class='load-more bg-secondary px-4 py-2'>Show more games</button>";
      }
      ?>

    </section>


  </main>
  <?php
  if ($view === "games") {
    echo '<script src="./js/load-more.js"></script>';
  }
  ?>

  <script defer type="module">

    import { addToDatabase } from '../public/js/connect-to-database.js'

    document.addEventListener('click', (event) => {
      const btn = event.target.closest('.dbc')
      if (!btn) return
      const btnId = btn.dataset.id
      addToDatabase([btnId])
    })

  </script>
</body>

</html>
<style>
  /* move to main.css later - targets only views displaying cards as to not break the layout */
  main .content:has(.card) {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
  }
</style>
