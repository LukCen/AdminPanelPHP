<?php
/** @var array $game  */

?>

<a href='?view=game_page&game=<?= $game['slug'] ?>' class="card flex flex-col gap-2 items-center p-2 bg-secondary">
  <img height="200" width="200" src="<?= htmlspecialchars($game['background_image'] ?? 'https://placehold.co/300x300') ?>" alt="">
  <div class="text flex flex-col gap-2">
    <p>Name: <?= htmlspecialchars($game['name']) ?></p>
    <p>Date of release: <?= htmlspecialchars($game['released']) ?></p>
    <button class="bg-light px-2 py-1 w-fit font-bold">Go to game page &rarr; </button>
  </div>
</a>

<style>
  .card {
    max-width: 20%;
    flex: 1 1 20%;
  }
</style>
