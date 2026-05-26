<?php
// session_start();
$views = [
  'games' => ['label' => 'Games', 'page_size' => 20],
  'developers' => ['label' => 'Developers', 'page_size' => 10],
  'favourites' => ['label' => 'Favourites', 'page_size' => 10]
];
$size = $views["games"]["page_size"];

$active_view = $_GET['view'] ?? 'games' . "&page_size=$size"
  ?>

<nav class="flex flex-col gap-2 p-2 bg-secondary">
  <h1>Admin panel</h1>
  <div class="input-group search bg-secondary flex flex-col gap-1">
    <form method="GET" class="flex justify-between flex-auto gap-1">
      <!-- <label for="searchbar">Search games</label> -->
      <!-- passes currently active view as a parameter to the url - makes sure page reload returns you to correct view post-reload -->
      <input type="hidden" name="view" value=<?= $active_view ?>>
      <input placeholder="Search for games" type="search" class="flex flex-auto bg-primary px-2 py-2" name="search" id="searchbar">
      <button type="submit" class="bg-primary flex flex-1/5 font-bold px-4 py-2">Search</button>
    </form>
  </div>
  <ul class="nav-menu flex flex-col gap-4">
    <h2>Browse by: </h2>
    <?php foreach ($views as $view => $param): ?>
      <li class="bg-primary px-4 py-2 rounded <?= $view === $active_view ? 'active' : '' ?>">
        <a class="block font-bold" href="?view=<?= $view ?>&page_size=<?= $param['page_size'] ?>">
          <?= ucfirst($view) ?>
        </a>
      </li>
    <?php endforeach; ?>
    <li class="bg-accent px-4 py-2 rounded flex justify-between">
      <a class="block font-bold" href="?view=login">Login/Register</a>
    </li>
    <div class="flex justify-around bg-primary py-2 items-center">
      <span>Hello, <?= $_SESSION["username"] ?? "Log in" ?>!</span>
      <button class="<?= $_SESSION["username"] ? 'block' : 'hidden' ?> logout bg-secondary px-2 py-1">Logout</button>
    </div>
  </ul>

  <div class="user-status flex justify-between">
  </div>
</nav>

<script type="module">
  const btnLogout = document.querySelector('.logout');
  btnLogout.
</script>
