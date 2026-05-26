<?php
/** @var array $dev */
?>

<div class="card flex flex-col gap-2 items-center rounded-xl p-2 bg-secondary">
  <img src="<?= htmlspecialchars($dev['image_background'] ?? "https://placehold.co/300x300") ?>" alt="">
  <div class="text flex flex-col flex-auto justify-around items-center gap-2">
    <h2><?= htmlspecialchars($dev["name"]) ?></h2>
    <p>Games count: <?= htmlspecialchars($dev["games_count"]) ?></p>
  </div>

  <a class="btn bg-primary font-bold px-4 py-2" href="?view=games&page_size=20&search=<?= htmlspecialchars($dev['name']) ?>">See games made by <?= ucfirst(htmlspecialchars($dev['name'])) ?></a>
</div>
