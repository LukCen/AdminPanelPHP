<?php

namespace App\Services;
use PDO;

class DatabaseService
{
  private $db;
  private $pdo;
  private $table;
  private $statement;

  public function __construct(string $db)
  {
    $this->db = $db;
    $this->pdo = $this->connect($db);
  }

  public function connect($db)
  {
    $pdo = new PDO(
      $db,
      options: [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );

    return $pdo;
  }

  public function select($table, $statement)
  {
    $stmt = $this->pdo->prepare(
      "SELECT $statement FROM $table"
    );

    $result = $stmt->fetch();

    return json_encode($result);
  }
}
