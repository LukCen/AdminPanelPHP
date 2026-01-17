<?php

header('Content-Type: application/json');
function connectToDatabase()
{
  $db = 'sqlite:' . __DIR__ . '/../database/admin_panel.db';

  $results = [];

  $db_connect = new PDO($db);
  foreach ($db_connect->query("SELECT * FROM games") as $row) {
    $results[] = $row;
  }

  echo json_encode($results);

}

connectToDatabase();

