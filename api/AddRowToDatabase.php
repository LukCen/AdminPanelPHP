<?php

require __DIR__ . '/../vendor/autoload.php';

if (file_exists(__DIR__ . '/../.env')) {
  Dotenv\Dotenv::createImmutable(__DIR__ . '/../')->load();
}

use App\Services\RawgService;

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

  $db = 'sqlite:' . __DIR__ . '/../database/admin_panel.db';

  $pdo = new PDO(
    $db,
    options: [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]
  );

  $service = new RawgService($_ENV['RAWG_API_KEY'] ?? getenv('RAWG_API_KEY'));

  $game = $service->fetchData("games/$data[0]");

  $stmt = $pdo->prepare(
    "INSERT INTO games (rawg_id, name, background_image, slug, released)
     VALUES (:rawg_id, :name, :background_image, :slug, :released)"
  );

  $stmt->execute([
    ':rawg_id' => $game['id'],
    ':name' => $game['name'],
    ':background_image' => $game['background_image'],
    ':slug' => $game['slug'],
    ':released' => $game['released']
  ]);

  echo json_encode(['success' => true]);
}

addRowToDatabase([$data]);
