<?php

  /**
   * Simple demo-"page" with the login form.
   * In a real application you would probably include an html-template here, but for this extremely simple
   * demo the "echo" statements are totally okay.
   */
  function showLoginForm()
  {

    echo '<h2>Login</h2>';

    echo '<form method="post" action="' . $_SERVER['SCRIPT_NAME'] . '" name="loginform">';
    echo '<label for="login_input_username">Username (or email)</label> ';
    echo '<input id="login_input_username" type="text" name="username" required /> ';
    echo '<label for="login_input_password">Password</label> ';
    echo '<input id="login_input_password" type="password" name="password" required /> ';
    echo '<input type="submit"  name="login" value="Log in" />';
    echo '</form>';

    echo '<a href="' . $_SERVER['SCRIPT_NAME'] . '?action=register">Register new account</a>';
  }

  /**
   * Simple demo-"page" with the registration form.
   * In a real application you would probably include an html-template here, but for this extremely simple
   * demo the "echo" statements are totally okay.
   */
  function showRegistrationForm()
  {

    echo '<h2>Registration</h2>';

    echo '<form method="post" action="' . $_SERVER['SCRIPT_NAME'] . '?action=doregister" name="registerform">';
    echo '<label for="login_input_username">Username (only letters and numbers, 2 to 64 characters)</label>';
    echo '<input id="login_input_username" type="text" pattern="[a-zA-Z0-9]{2,64}" name="username" required />';
    echo '<label for="login_input_email">User\'s email</label>';
    echo '<input id="login_input_email" type="email" name="email" required />';
    echo '<label for="login_input_password_new">Password (min. 6 characters)</label>';
    echo '<input id="login_input_password_new" class="login_input" type="password" name="password_new" pattern=".{6,}" required autocomplete="off" />';
    echo '<label for="login_input_password_repeat">Repeat password</label>';
    echo '<input id="login_input_password_repeat" class="login_input" type="password" name="password_repeat" pattern=".{6,}" required autocomplete="off" />';
    echo '<input type="submit" name="register" value="Register" />';
    echo '</form>';

    echo '<a href="' . $_SERVER['SCRIPT_NAME'] . '">Homepage</a>';
  }

//login & logout unnecessary, function of calling new $session()
//$session->doLogin();

//HTML begin

if ($action == "login") {
  showLoginForm();
}
elseif ($action == "register") {
  showRegistrationForm();
}
elseif ($action == "doregister") {
  $session->doRegister();
  echo '<p>' . $session->feedback . '</p>';
}
elseif ($action == "logout") {
  // logs out in doLogin(), magic!
  echo '<p>' . $session->feedback . '</p>';
}
else { echo "<p>Please choose Login, Register or Logout.</p>"; }
