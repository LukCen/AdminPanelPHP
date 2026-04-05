<?php
/** @var array $game  */
?>



<div class="card flex flex-col gap-2 items-center rounded-xl p-2 bg-secondary">
  <img src="<?= htmlspecialchars($game['background_image'] ?? 'https://placehold.co/300x300') ?>" alt="">
  <div class="text flex flex-col flex-auto justify-around items-center gap-2">
    <h2><?= htmlspecialchars($game['name']) ?></h2>
    <p>Released: <?= htmlspecialchars($game['released']) ?></p>
    <a href='?view=game_page&game=<?= $game['slug'] ?>' class="btn bg-light text-primary px-2 py-1 max-w-fit text-center font-bold">Go to game page &rarr; </a>
    <span class="badge-favourite justify-center items-center font-bold w-fit px-2 py-1 <?= $is_in_favourites ? 'flex' : 'hidden' ?>">Favourite</span>
  </div>
  <!-- add to favourites -->
  <button data-id="<?= htmlspecialchars($game["id"]) ?>" class="btn dbc flex items-center gap-2 bg-primary px-2 py-2 w-fit font-bold">
    <span>Add to favourites</span>
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
      class="lucide lucide-loader-icon lucide-loader rotate hidden">
      <path d="M12 2v4" />
      <path d="m16.2 7.8 2.9-2.9" />
      <path d="M18 12h4" />
      <path d="m16.2 16.2 2.9 2.9" />
      <path d="M12 18v4" />
      <path d="m4.9 19.1 2.9-2.9" />
      <path d="M2 12h4" />
      <path d="m4.9 4.9 2.9 2.9" />
    </svg>
  </button>
  <!-- spinner for oading -->

  <!-- remove from favourites -->
  <button data-id="<?= htmlspecialchars($game["id"]) ?>" class="btn dbr flex items-center bg-light text-secondary px-2 py-2 w-fit font-bold">
    <span>Remove from favourites</span>
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
      class="lucide lucide-loader-icon lucide-loader rotate hidden">
      <path d="M12 2v4" />
      <path d="m16.2 7.8 2.9-2.9" />
      <path d="M18 12h4" />
      <path d="m16.2 16.2 2.9 2.9" />
      <path d="M12 18v4" />
      <path d="m4.9 19.1 2.9-2.9" />
      <path d="M2 12h4" />
      <path d="m4.9 4.9 2.9 2.9" />
    </svg>
  </button>
  <!-- marker, displayed for 3s after adding, disappears after -->
  <span data-id=<?= $game['id'] ?> class="hidden database-add-marker bg-light px-4 py-1 text-center font-bold">Added to favourites!</span>
</div>
