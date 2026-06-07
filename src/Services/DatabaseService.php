<?php

namespace App\Services;
use PDO;

class DatabaseService
{
  private $db;
  private $pdo;

  public function __construct($db)
  {
    $this->db = $db;
    $this->pdo = $this->connect($db);
  }

  private function connect($db)
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

  public function insert($table, array $data)
  {
    $keys = array_keys($data);
    $values = array_values($data);

    $listedKeys = implode(",", $keys);
    $toExecute = array_map(fn($listedKeys) => ":" . $listedKeys, $keys);

    $placeholderValues = implode(",", $toExecute);
    $stmt = $this->pdo->prepare("INSERT INTO $table ($listedKeys) VALUES($placeholderValues)");
    $stmt->execute(array_combine($toExecute, $values));
  }
}
