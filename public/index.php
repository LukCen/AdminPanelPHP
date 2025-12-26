<?php

require __DIR__ . '/../vendor/autoload.php';

if (file_exists(__DIR__ . '/../.env')) {
  Dotenv\Dotenv::createImmutable(__DIR__ . '/../')->load();
}
use Acme\RawgService;


$service = new RawgService($_ENV['RAWG_API_KEY'] ?? getenv('RAWG_API_KEY'));

// $games_with_params = $service->fetchGamesWithParam("page_size=5");

// return the results array OR an empty array
$games_with_params_return = $games_with_params['results'] ?? [];


$games_list = $service->fetchData("games", array("page_size" => 5));

$games_list_results = $games_list['results'] ?? [];

$devs_list = $service->fetchData("developers", array("page_size" => 5));



?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./css/main.css">
  <title>This is home page.</title>

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


  ?>
  <!-- main content - right side of the page -->
  <main class="flex flex-col gap-2 p-2 bg-primary">
    <section class="flex flex-col gap-4 items-center">
      <h2><?php echo ucfirst($view ?? "Games") ?></h2>
      <div class="content flex gap-5">
        <?php

        if ($view === "games") {
          foreach ($games_list_results as $game):
            include __DIR__ . '/../src/GameCard.php';
          endforeach;
        }
        if ($view === "developers") {
          foreach ($devs_list['results'] as $dev):
            include __DIR__ . '/../src/DeveloperCard.php';
          endforeach;
        }
        ?>
      </div>
    </section>

    <?php
    // $game_page = $_GET["game_page"] ?? null;
    // $game_view = $service->fetchDataGamePage("games", $game_page);
    // var_dump(CURL_URL);
    if ($view === "game_page") {

      include __DIR__ . '/../src/GamePage.php';

    }

    ?>
  </main>


</body>

</html>
