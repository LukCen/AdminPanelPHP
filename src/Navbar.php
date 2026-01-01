<?php

$views = [
  'games' => ['label' => 'Games', 'page_size' => 20],
  'developers' => ['label' => 'Developers', 'page_size' => 10]
];

$active_view = $_GET['view'] ?? 'games'
  ?>

<nav class="flex flex-col gap-2 p-2 bg-secondary">
  <h1>Admin panel</h1>
  <div class="input-group flex flex-col gap-1">
    <form method="GET">
      <label for="searchbar">Search games</label>
      <!-- passes currently active view as a parameter to the url - makes sure page reload returns you to correct view post-reload -->
      <input type="hidden" name="view" value=<?= $active_view ?>>
      <input type="search" name="search" id="searchbar">
      <button type="submit" class="bg-primary font-bold px-4 py-2">Search</button>
    </form>
  </div>
  <ul class="flex flex-col gap-1">
    <h2>Browse by: </h2>
    <?php
    foreach ($views as $view => $param):
      echo "<li><a href='?view={$view}&page_size={$param["page_size"]}'>" . ucfirst($view) . "</a></li>";
    endforeach;
    ?>
  </ul>
</nav>
