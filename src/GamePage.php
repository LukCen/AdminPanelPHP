<?php
/** @var array $game_page */

use App\Services\RawgService;

$service = new RawgService($_ENV['RAWG_API_KEY'] ?? getenv('RAWG_API_KEY'));
$game_view = $service->fetchDataGamePage("games", $_GET['game']);

$game_results = $game_view;

$ratings = [
  "everyone" => [
    "text" => "everyone",
    "image" => "../public/assets/icons/esrb-everyone.png"
  ],
  "everyone-10-plus" => [
    "text" => "everyone 10+",
    "image" => "../public/assets/icons/esrb-everyone-plus-10.png"
  ],
  "teen" => [
    "text" => "teen",
    "image" => "../public/assets/icons/esrb-teen.png"
  ],
  "mature" => [
    "text" => "mature",
    "image" => "../public/assets/icons/esrb-mature.png"
  ],
  "adults-only" => [
    "text" => "adults only",
    "image" => "../public/assets/icons/esrb-adults-only.png"
  ]
]
  ?>
<main class="p-2">
  <section class="base-info flex flex-col gap-2 items-center">
    <div class="base-info flex flex-col gap-4">
      <!-- basic info  -->
      <div class="title-and-score flex justify-between items-center gap-5">
        <?php
        //  coloring the grade element
        $game_color;
        $metacritic = $game_results['metacritic'];
        switch ($metacritic) {
          case ($metacritic > 90):
            $game_color = "metacritic-great";
            break;
          case ($metacritic > 70):
            $game_color = "metacritic-good";
            break;
          case ($metacritic > 50):
            $game_color = "metacritic-average";
            break;
          case ($metacritic > 30):
            $game_color = "metacritic-bad";
            break;
          case ($metacritic < 30):
            $game_color = "metacritic-very-bad";
            break;
          case (!isset($metacritic)):
            $game_color = "#333";
            break;
        }

        ?>
        <span class="game-metacritic flex items-center justify-center <?= $game_color ?>"><?= $game_results['metacritic'] ? htmlspecialchars($game_results['metacritic']) : "X" ?></span>
        <!-- rating -->
        <div class="flex gap-2 items-center justify-center">
          <span>ESRB rating:</span>
          <img width="50" height="50" class="bg-light" src="
          <?=
            isset($game_results['esrb_rating']['slug'])
            ? $ratings[$game_results['esrb_rating']['slug']]["image"]
            : "https://placehold.co/50x50?text=X";
          ?>" />
          <?= htmlspecialchars(isset($game_results["esrb_rating"]["name"])) ? $game_results["esrb_rating"]["name"] : "Unrated" ?>
        </div>

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
        <div class="flex flex-col gap-4 w-1/2">
          <h1 class="text-center"><?= htmlspecialchars($game_results['name']) ?></h1>
          <?= htmlspecialchars($game_results["description_raw"]) ?>
        </div>
      </section>

      <!-- platforms -->
      <div class="platforms flex items-center gap-2 justify-start">
        <p class="font-medium">Available on :</p>
        <?php
        foreach ($game_results["platforms"] as $platform):
          $platform_name = $platform['platform']["name"];
          echo "<span class='bg-secondary px-4 py-2 text-center'>$platform_name</span>";
        endforeach;
        ?>
      </div>

      <!-- genres -->
      <div class="genres flex items-center gap-2 justify-center items-self-start">
        <p class="font-medium">Genres :</p>
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
  }

  .metacritic-great {
    background: #00ff00;
    color: #000;
  }

  .metacritic-good {
    background: #9cfd00;
    color: #000;
  }

  .metacritic-average {
    background: #fbff04;
    color: #000;
  }

  .metacritic-bad {
    background: #ff9900;
  }

  .metacritic-very-bad {
    background: #ff3300;
  }

  .metacritic-critical {
    background: #000;
  }
</style>
