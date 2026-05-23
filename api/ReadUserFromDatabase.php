<?php
session_start();
function readUser(array $data)
{
  $db = 'sqlite:' . __DIR__ . '/../database/admin_panel.db';

  $pdo = new PDO(
    $db,
    options: [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
  );

  $stmt = $pdo->prepare(
    "SELECT * FROM users WHERE username=:username"
  );
  $stmt->execute([
    ":username" => $data["login-username"]
  ]);

  $results = $stmt->fetch();

  $passwordMatches = password_verify($data["login-password"], $results["password_hash"]);
  echo
    json_encode(['success' => true]);

  if ($passwordMatches) {
    $_SESSION["username"] = $results["username"];
    header('Location: /admin_panel/public');
    exit();
  } else {
    echo "WRONG PASSWORD OR USERNAME";
  }
}

readUser($_POST)
  ?>

