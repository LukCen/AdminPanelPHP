<?php
/** @var array $game  */
?>



<div class="card flex flex-col gap-2 max-w-1/5 flex-1/5 items-center rounded-xl p-2 bg-secondary">
  <img height="200" width="200" src="<?= htmlspecialchars($game['background_image'] ?? 'https://placehold.co/300x300') ?>" alt="">
  <div class="text flex flex-col flex-auto justify-between gap-2">
    <p><?= htmlspecialchars($game['name']) ?></p>
    <p>Released: <?= htmlspecialchars($game['released']) ?></p>

    <a href='?view=game_page&game=<?= $game['slug'] ?>' class="bg-light text-primary px-2 py-1 w-fit text-center font-bold">Go to game page &rarr; </a>
    <!-- for testing -->
  </div>
  <a data-id="<?= htmlspecialchars($game["id"]) ?>" class="dbc bg-primary px-2 py-2 w-fit font-bold">Add to database</a>
  <span data-id=<?= $game['id'] ?> class="database-add-marker bg-light px-4 py-1 text-center font-bold"></span>
</div>
