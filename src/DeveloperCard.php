<?php
/** @var array $dev */
?>

<div class="card max-w-1/5 flex-1/5 flex flex-col gap-2 items-center p-2 bg-secondary">
  <img height="200" width="200" src="<?= htmlspecialchars($dev['image_background'] ?? "https://placehold.co/300x300") ?>" alt="">
  <div class="text flex flex-col gap-2">
    <p>Name: <?= htmlspecialchars($dev["name"]) ?></p>
    <p>Games count: <?= htmlspecialchars($dev["games_count"]) ?></p>
  </div>
</div>
