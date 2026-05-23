<?php
function addUser(array $data)
{
  $db = 'sqlite:' . __DIR__ . '/../database/admin_panel.db';

  $pdo = new PDO(
    $db,
    options: [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
  );
  // $service = new RawgService($_ENV['RAWG_API_KEY'] ?? getenv('RAWG_API_KEY'));
  $stmt = $pdo->prepare(
    "INSERT INTO users (username, password_hash,email)
     VALUES (:username,:password_hash, :email)"
  );

  $stmt->execute([
    ":username" => $data["register-username"],
    ":password_hash" => password_hash($data["register-password"], PASSWORD_BCRYPT),
    ":email" => $data["register-email"]
  ]);
  echo json_encode(['success' => true]);
}

addUser($_POST);
?>

