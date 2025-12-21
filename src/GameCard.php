<?php
/** @var array $game */
?>

<div class="card flex flex-col gap-1 items-center p-2">
  <img height="200" width="200" src="<?= htmlspecialchars($game['background_image'] ?? 'https://placehold.co/300x300') ?>" alt="">
  <div class="text flex flex-col gap-1">
    <p>Name: <?= htmlspecialchars($game['name']) ?></p>
    <p>Date of release: <?= htmlspecialchars($game['released']) ?></p>
  </div>
</div>
