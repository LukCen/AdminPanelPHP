<?php
$login = BASE_PATH . "/api/Login.php";
$register = BASE_PATH . "/api/Register.php";
?>

<form action="<?= $login ?>" method="post">
  <fieldset class="flex flex-col gap-2">
    <legend>Log in</legend>
    <label for="login-username">Username</label>
    <input type="text" id="login-username" name="login-username">
    <label for="login-password">Password</label>
    <input type="password" id="login-password" name="login-password">
    <button class="btn-login bg-secondary" type="submit">Log in</button>
  </fieldset>

</form>
<form action='<?= $register ?>' method="post">
  <fieldset class="flex flex-col gap-2">
    <legend>Register</legend>
    <label for="register-username">Username</label>
    <input type="text" id="register-username" name="register-username">
    <label for="register-password">Password</label>
    <input type="password" id="register-password" name="register-password">
    <label for="register-email">Email</label>
    <input id="register-email" type="email" name="register-email">
    <button class="btn-register bg-secondary" type="submit">Register a new account</button>
  </fieldset>
</form>
