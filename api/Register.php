<?php

$new_user = [
  'username' => $_POST["register-username"],
  "password" => $_POST["register-password"],
  "email" => $_POST["register-email"]
];

require_once __DIR__ . "/AddUserToDatabase.php"
;
?>

