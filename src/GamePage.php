<?php
/** @var array $game_page */

use Acme\RawgService;
$service = new RawgService($_ENV['RAWG_API_KEY'] ?? getenv('RAWG_API_KEY'));
$game_view = $service->fetchDataGamePage("games", $_GET['game']);

$game_results = $game_view;
// var_dump($game_results);
?>


<main>
  <section class="base-info flex flex-col gap-2 items-center">
    <div class="base-info">
      <div class="title-and-score flex justify-between items-center gap-5">
        <span class="game-metacritic flex items-center justify-center"><?= htmlspecialchars($game_results['metacritic']) ?></span>
        <h1 class="text-center"><?= htmlspecialchars($game_results['name']) ?></h1>
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
