<?php
/** @var array $dev */
?>



<div class="card flex flex-col gap-1 items-center p-2">
  <img height="200" width="200" src="<?= htmlspecialchars($dev['image_background'] ?? "https://placehold.co/300x300") ?>" alt="">
  <div class="text flex flex-col gap-1">
    <p>Name: <?= htmlspecialchars($dev["name"]) ?></p>
    <p>Games count: <?= htmlspecialchars($dev["games_count"]) ?></p>
  </div>

</div>
