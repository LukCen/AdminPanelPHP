<?php

require __DIR__ . '/../vendor/autoload.php';

if (file_exists(__DIR__ . '/../.env')) {
  Dotenv\Dotenv::createImmutable(__DIR__ . '/../')->load();
}

use App\Services\RawgService;

header('Content-Type: application/json');


$data = json_decode(file_get_contents('php://input'), true);
if (!isset($data)) {
  http_response_code(400);
  echo json_encode(['error' => 'Missing game ID']);
  exit;
}

function removeRowFromDatabase(array $data)
{
  $db = 'sqlite:' . __DIR__ . '/../database/admin_panel.db';

  $pdo = new PDO(
    $db,
    options: [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]
  );
  $service = new RawgService(($_ENV['RAWG_API_KEY'] ?? getenv('RAWG_API_KEY')));

  $game = $service->fetchData("games/$data[0]");


  $stmt = $pdo->prepare(
    "DELETE FROM games WHERE rawg_id = :rawg_id"
  );

  $stmt->execute([':rawg_id' => $game['id']]);

  echo json_encode(['success' => true]);
}

removeRowFromDatabase([$data]);

