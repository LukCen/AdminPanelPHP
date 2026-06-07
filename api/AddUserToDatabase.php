<?php
namespace App\api;
require_once __DIR__ . '/../vendor/autoload.php';
use App\Services\DatabaseService;
function addUser(array $data)
{
  $db = 'sqlite:' . __DIR__ . '/../database/admin_panel.db';

  $database = new DatabaseService($db);
  $database->insert("users", $data);
}
$new_user = [
  'username' => $_POST["register_username"],
  "password_hash" => password_hash($_POST["register_password"], PASSWORD_BCRYPT),
  "email" => $_POST["register_email"]
];
addUser($new_user);
?>

