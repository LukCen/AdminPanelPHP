<?php

use Acme\RawgService;
require __DIR__ . '/../vendor/autoload.php';

if (file_exists(__DIR__ . '/../.env')) {
  Dotenv\Dotenv::createImmutable(__DIR__ . '/../')->load();
}
// require_once __DIR__ . '/../src/RawgService.php';
$client = new RawgService($_ENV['RAWG_API_KEY'] ?? getenv('RAWG_API_KEY'));

header('Content-Type: application/json');
// dev only - prevents caching and associated weird behaviours
header('Cache-Control: no-store');
$page = max(1, (int) ($_GET['page'] ?? 1));


try {
  $data = $client->fetchData('games', [
    'page' => $page,
    'page_size' => 20
  ]);
  echo json_encode($data);
} catch (Throwable $err) {
  http_response_code(500);
  echo json_encode(['error' => $err->getMessage()()]);
}
