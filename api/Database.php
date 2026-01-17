<?php

header('Content-Type: application/json');
function connectToDatabase()
{
  $db = 'sqlite:D:/Programowanie/Projekty/various/sqlite_db/admin_panel.db';

  $results = [];

  $db_connect = new PDO($db);
  foreach ($db_connect->query("SELECT * FROM games") as $row) {
    $results[] = $row;
  }

  echo json_encode($results);

}

connectToDatabase();

