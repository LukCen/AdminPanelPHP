<?php
/** @var array $game_page */

use Acme\RawgService;
$service = new RawgService($_ENV['RAWG_API_KEY'] ?? getenv('RAWG_API_KEY'));
$game_view = $service->fetchDataGamePage("games", $_GET['game']);

$game_results = $game_view;

?>


<main>
  <section class="base-info flex flex-col gap-2 items-center">
    <div class="base-info flex flex-col gap-4">
      <!-- basic info  -->
      <div class="title-and-score flex justify-between items-center gap-5">
        <span class="game-metacritic flex items-center justify-center"><?= htmlspecialchars($game_results['metacritic']) ?></span>
        <h1 class="text-center"><?= htmlspecialchars($game_results['name']) ?></h1>
      </div>
      <!-- developer info -->
      <div class="developers flex gap-2 justify-center gap-5">
        <span class="flex items-center justify-center text-center">Developers :</span>
        <?php
        foreach ($game_results["developers"] as $devs):
          echo "<span class='bg-secondary px-4 py-2 text-center'>" . $devs["name"] . "</span>";
        endforeach;
        ?>
      </div>
      <!-- image + desc -->
      <section class="img-and-text flex gap-2">
        <img class="w-1/2" src=<?= htmlspecialchars($game_results["background_image"]) ?> alt="">
        <p class="flex w-1/2">
          <?= htmlspecialchars($game_results["description_raw"]) ?>

        </p>
      </section>
      <!-- platforms -->
      <div class="platforms flex items-center gap-2 justify-between">
        <p>Available on :</p>
        <?php
        foreach ($game_results["platforms"] as $platform):
          $platform_name = $platform['platform']["name"];
          echo "<span class='bg-secondary px-4 py-2 text-center'>$platform_name</span>";
        endforeach;
        ?>
      </div>
      <!-- genres -->
      <div class="platforms flex items-center gap-2 justify-center">
        <p>Genres :</p>
        <?php
        foreach ($game_results["genres"] as $genre):
          $genre_name = $genre["name"];
          echo "<span class='bg-secondary px-4 py-2 text-center'>$genre_name</span>";
        endforeach;
        ?>
      </div>
    </div>
  </section>
</main>
<style>
  .game-metacritic {
    font-size: 36px;
    font-weight: bold;
    min-width: 50px;
    min-height: 50px;
    border-radius: 50%;
    padding: 10px;
    border: 3px solid var(--color-light);
  }
</style>
