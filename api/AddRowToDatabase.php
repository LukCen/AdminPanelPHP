<?php

require __DIR__ . '/../vendor/autoload.php';

if (file_exists(__DIR__ . '/../.env')) {
  Dotenv\Dotenv::createImmutable(__DIR__ . '/../')->load();
}

use Acme\RawgService;

header('Content-Type: application/json');

// Read request body ONCE
$data = json_decode(file_get_contents('php://input'), true);


if (!isset($data)) {
  http_response_code(400);
  echo json_encode(['error' => 'Missing game ID']);
  exit;
}


function addRowToDatabase(array $data)
{
  // REMOVE 
  // debug_log($data, "Testing");

  $db = 'sqlite:D:/Programowanie/Projekty/various/sqlite_db/admin_panel.db';

  $pdo = new PDO(
    $db,
    options: [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]
  );

  $service = new RawgService($_ENV['RAWG_API_KEY'] ?? getenv('RAWG_API_KEY'));

  $game = $service->fetchData("games/$data[0]");

  $stmt = $pdo->prepare(
    "INSERT INTO games (rawg_id, name, featured)
     VALUES (:rawg_id, :name, :featured)"
  );

  $stmt->execute([
    ':rawg_id' => $game['id'],
    ':name' => $game['name'],
    ':featured' => 1
  ]);

  echo json_encode(['success' => true]);
}

addRowToDatabase([$data]);

