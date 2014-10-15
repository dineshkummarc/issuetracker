<?php

// add mysql.php, this starts medoo()
// add functions.php
require_once '../include/mysql.php';
require_once '../include/functions.php';

/**
 * based on php-login-one-file
 *
 * @author Daniel Mayoss
 * original author Panique
 * original source link https://github.com/panique/php-login-one-file/
 * @license http://opensource.org/licenses/MIT MIT License (this file)
 */

class OneFileLoginApplication
{
  /**
   * @var bool Login status of user
   */
  private $user_is_logged_in = false;

  /**
   * @var string System messages, likes errors, notices, etc.
   */
  public $feedback = "";


  /**
   * Does necessary checks for PHP version and PHP password compatibility library and runs the application
   */
  public function __construct()
  {
    if ($this->performMinimumRequirementsCheck()) {
      $this->runApplication();
    }
  }

  /**
   * Performs a check for minimum requirements to run this application.
   * Does not run the further application when PHP version is lower than 5.3.7
   * Does include the PHP password compatibility library when PHP version lower than 5.5.0
   * (this library adds the PHP 5.5 password hashing functions to older versions of PHP)
   * @return bool Success status of minimum requirements check, default is false
   */
  private function performMinimumRequirementsCheck()
  {
    if (version_compare(PHP_VERSION, '5.3.7', '<')) {
      echo "Sorry, Simple PHP Login does not run on a PHP version older than 5.3.7 !";
    } elseif (version_compare(PHP_VERSION, '5.5.0', '<')) {
      require_once("../include/password_compatibility_library.php");
      return true;
    } elseif (version_compare(PHP_VERSION, '5.5.0', '>=')) {
      return true;
    }
    // default return
    return false;
  }

  /**
   * This is basically the controller that handles the entire flow of the application.
   */
  public function runApplication()
  {
    // check if user wants to see register page
    if ($_GET["action"] == "register") {
      $this->doRegistration();
      $this->showPageRegistration();
    } else {
      // start the session, always needed!
      $this->doStartSession();
      // check for possible user interactions (login with session/post data or logout)
      $this->performUserLoginAction();
      // show "page", according to user's login status
      if ($this->getUserLoginStatus()) {
        $this->showPageLoggedIn();
      } else {
        $this->showPageLoginForm();
      }
    }
  }

  /**
   * Handles the flow of the login/logout process. According to the circumstances, a logout, a login with session
   * data or a login with post data will be performed
   */
  private function performUserLoginAction()
  {
    if (isset($_GET["action"]) && ($_GET["action"] == "logout")) {
      $this->doLogout();
    } elseif (!empty($_SESSION['username']) && ($_SESSION['user_is_logged_in'])) {
      $this->doLoginWithSessionData();
    } elseif (isset($_POST["login"])) {
      $this->doLoginWithPostData();
    }
  }

  /**
   * Simply starts the session.
   * It's cleaner to put this into a method than writing it directly into runApplication()
   */
  private function doStartSession()
  {
    session_start();
  }

  /**
   * Set a marker (NOTE: is this method necessary ?)
   */
  private function doLoginWithSessionData()
  {
    $this->user_is_logged_in = true; // ?
  }

  /**
   * Process flow of login with POST data
   */
  private function doLoginWithPostData()
  {
    if ($this->checkLoginFormDataNotEmpty()) {
      $this->checkPasswordCorrectnessAndLogin();
    }
  }

  /**
   * Logs the user out
   */
  private function doLogout()
  {
    $_SESSION = array();
    session_destroy();
    $this->user_is_logged_in = false;
    $this->feedback = "You were just logged out.";
  }

  /**
   * The registration flow
   * @return bool
   */
  private function doRegistration()
  {
    if ($this->checkRegistrationData()) {
      $this->createNewUser();
    }
    // default return
    return false;
  }

  /**
   * Validates the login form data, checks if username and password are provided
   * @return bool Login form data check success state
   */
  private function checkLoginFormDataNotEmpty()
  {
    if (!empty($_POST['username']) && !empty($_POST['password'])) {
      return true;
    } elseif (empty($_POST['username'])) {
      $this->feedback = "Username field was empty.";
    } elseif (empty($_POST['password'])) {
      $this->feedback = "Password field was empty.";
    }
    // default return
    return false;
  }

  /**
   * Checks if user exists, if so: check if provided password matches the one in the database
   * @return bool User login success status
   */
  private function checkPasswordCorrectnessAndLogin() {
   global $database;

   $result=$database->get("users",
    array("users.username(username)",
          "users.email(email)",
          "users.passhash(passhash)"
         ),
    array("OR" => array("users.username[=]" => $_POST['username'],"users.email[=]" => $_POST['username']))
    );

  if ($result) {
  // using PHP 5.5's password_verify() function to check password
   if (password_verify($_POST['password'], $result["passhash"])) {
   // write user data into PHP SESSION [a file on your server]
     $_SESSION['username'] = $result["username"];
     $_SESSION['email'] = $result["email"];
     $_SESSION['user_is_logged_in'] = true;
     $this->user_is_logged_in = true;
     return true;
   }
   else {
    $this->feedback = "Wrong password.";
   }
  }
  else {
   $this->feedback = "This user does not exist.";
  }
  // default return
  return false;
  }

  /**
   * Validates the user's registration input
   * @return bool Success status of user's registration data validation
   */
  private function checkRegistrationData()
  {
   // if no registration form submitted: exit the method
   if (!isset($_POST["register"])) {
    return false;
   }

   // validating the input
   if (!empty($_POST['username'])
    && strlen($_POST['username']) <= 64
    && strlen($_POST['username']) >= 2
    && preg_match('/^[a-z\d]{2,64}$/i', $_POST['username'])
    && !empty($_POST['email'])
    && strlen($_POST['email']) <= 64
    && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)
    && !empty($_POST['password_new'])
    && !empty($_POST['password_repeat'])
    && ($_POST['password_new'] === $_POST['password_repeat'])
    ) {
     // only this case return true, only this case is valid
     return true;
     }
    elseif (empty($_POST['username'])) {
     $this->feedback = "Empty Username";
    } elseif (empty($_POST['password_new']) || empty($_POST['password_repeat'])) {
      $this->feedback = "Empty Password";
    } elseif ($_POST['password_new'] !== $_POST['password_repeat']) {
      $this->feedback = "Password and password repeat are not the same";
    } elseif (strlen($_POST['password_new']) < 6) {
      $this->feedback = "Password has a minimum length of 6 characters";
    } elseif (strlen($_POST['username']) > 64 || strlen($_POST['username']) < 2) {
      $this->feedback = "Username cannot be shorter than 2 or longer than 64 characters";
    } elseif (!preg_match('/^[a-z\d]{2,64}$/i', $_POST['username'])) {
      $this->feedback = "Username does not fit the name scheme: only a-Z and numbers are allowed, 2 to 64 characters";
    } elseif (empty($_POST['email'])) {
      $this->feedback = "Email cannot be empty";
    } elseif (strlen($_POST['email']) > 64) {
      $this->feedback = "Email cannot be longer than 64 characters";
    } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
      $this->feedback = "Your email address is not in a valid email format";
    } else {
      $this->feedback = "An unknown error occurred.";
    }

    // default return
    return false;
  }

  /**
   * Creates a new user.
   * @return bool Success status of user registration
   */
  private function createNewUser()
  {
    global $database;

    // remove html code etc. from username and email
    $username = htmlentities($_POST['username'], ENT_QUOTES);
    $email = htmlentities($_POST['email'], ENT_QUOTES);
    $password = $_POST['password_new'];
    // crypt the user's password with the PHP 5.5's password_hash() function, results in a 60 char hash string.
    // the constant PASSWORD_DEFAULT comes from PHP 5.5 or the password_compatibility_library
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    $result=$database->count("users",
                       array("OR" => array("users.username[=]" => $_POST['username'],"users.email[=]" => $_POST['username'])));

    if ($result) {
      $this->feedback = "Sorry, that username or email is already taken. Please choose another one.";
    }
    else {
      echo "we're in the create a user section.";
      $result=$database->insert("users",
                           array("username" => $username,
                                 "passhash" => $password_hash,
                                 "email" => $email));

      if ($result) {
        $this->feedback = "Your account has been created successfully. You can now log in.";
        return true;
      }
      else {
        $this->feedback = "Sorry, your registration failed. Please go back and try again.";
      }
    }
    // default return
    return false;
  }

  /**
   * Simply returns the current status of the user's login
   * @return bool User's login status
   */
  public function getUserLoginStatus()
  {
   return $this->user_is_logged_in;
  }

  /**
   * Simple demo-"page" that will be shown when the user is logged in.
   * In a real application you would probably include an html-template here, but for this extremely simple
   * demo the "echo" statements are totally okay.
   */
  private function showPageLoggedIn()
  {
    if ($this->feedback) {
      echo $this->feedback . "<br/><br/>";
    }

    echo 'Hello ' . $_SESSION['username'] . ', you are logged in.<br/><br/>';
    echo '<a href="' . $_SERVER['SCRIPT_NAME'] . '?action=logout">Log out</a>';
  }

  /**
   * Simple demo-"page" with the login form.
   * In a real application you would probably include an html-template here, but for this extremely simple
   * demo the "echo" statements are totally okay.
   */
  private function showPageLoginForm()
  {
    if ($this->feedback) {
      echo $this->feedback . "<br/><br/>";
    }

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
  private function showPageRegistration()
  {
    if ($this->feedback) {
      echo $this->feedback . "<br/><br/>";
    }

    echo '<h2>Registration</h2>';

    echo '<form method="post" action="' . $_SERVER['SCRIPT_NAME'] . '?action=register" name="registerform">';
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
}

// run the application
$application = new OneFileLoginApplication();
