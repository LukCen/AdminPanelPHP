<?php


$login = BASE_PATH . "/api/Login.php";
$register = BASE_PATH . "/api/Register.php";

?>

<form action="<?= $login ?>" method="post">
  <fieldset class="flex flex-col gap-2">
    <legend>Log in</legend>
    <label for="login_username">Username</label>
    <input type="text" id="login_username" name="login_username">
    <label for="login-password">Password</label>
    <input type="password" id="login_password" name="login_password">
    <button class="btn-login bg-secondary" type="submit">Log in</button>
  </fieldset>

</form>
<form action='<?= $register ?>' method="post">
  <fieldset class="flex flex-col gap-2">
    <legend>Register</legend>
    <label for="register_username">Username</label>
    <input type="text" id="register_username" name="register_username">
    <label for="register_password">Password</label>
    <input type="password" id="register_password" name="register_password">
    <label for="register_email">Email</label>
    <input id="register_email" type="email" name="register_email">
    <button class="btn-register bg-secondary" type="submit">Register a new account</button>
  </fieldset>
</form>
