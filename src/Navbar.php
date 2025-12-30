<?php

$views = [
  'games' => ['label' => 'Games', 'page_size' => 20],
  'developers' => ['label' => 'Developers', 'page_size' => 5]
];

?>


<nav class="flex flex-col gap-2 p-2 bg-secondary">
  <h1>Admin panel</h1>
  <div class="input-group flex flex-col gap-1">
    <form method="GET">
      <label for="searchbar">Search games</label>
      <input type="hidden" name="view" value="games">
      <input type="search" name="search" id="searchbar">
      <button type="submit" class="bg-light px-4 py-2">Search</button>
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
