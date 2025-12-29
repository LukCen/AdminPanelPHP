<?php

$views = [
  'games' => ['label' => 'Games', 'page_size' => 20],
  'developers' => ['label' => 'Developers', 'page_size' => 5]
]

  ?>


<nav class="flex flex-col gap-2 p-2 bg-secondary">
  <ul class="flex flex-col gap-1">
    <h2>Browse by: </h2>
    <?php
    foreach ($views as $view => $param):

      echo "<li><a href='?view={$view}&page_size={$param["page_size"]}'>" . ucfirst($view) . "</a></li>";
    endforeach;
    ?>
  </ul>
</nav>
