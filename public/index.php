<?php
require '../vendor/autoload.php';
use Acme\RawgService;
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$service = new RawgService($_ENV['RAWG_API_KEY']);

$games_with_params = $service->fetchGamesWithParam("page_size=5");

// return the results array OR an empty array
$games_with_params_return = $games_with_params['results'] ?? [];
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
  <nav class="flex flex-col gap-2 p-2">
    <ul class="flex flex-col gap-1">
      <h2>Browse by: </h2>
      <li>
        <a href="">Games</a>
      </li>
      <li>
        <a href="">Genres</a>
      </li>
      <li>
        <a href="">Developers</a>
      </li>
      <li>
        <a href="">Publishers</a>
      </li>
      <li>
        <a href="">Tags</a>
      </li>
    </ul>
  </nav>
  <main class="flex flex-col gap-2 p-2">
    <section class="flex flex-col gap-2 items-center">
      <h2>Newest games</h2>
      <div class="content flex gap-5">
        <?php foreach ($games_with_params_return as $game): ?>
          <?php include __DIR__ . '/../src/GameCard.php'; ?>
        <?php endforeach; ?>

      </div>
    </section>
  </main>

</body>

</html>
