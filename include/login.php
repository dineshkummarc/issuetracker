<?php

/**
 * based on php-login-one-file
 *
 * @author Daniel Mayoss
 * original author Panique
 * original source link https://github.com/panique/php-login-one-file/
 * @license http://opensource.org/licenses/MIT MIT License (for this file)
 */

class Session
{
  /**
   * @var bool Login status of user
   */
  public $logged_in = false;

  /**
   * @var string System messages, like errors, notices, etc.
   */
  public $feedback = "";

  /**
   * Does necessary checks for PHP version and PHP password compatibility library and runs the application
   */
  public function __construct()
  {
    if ($this->checkRequirements()) { $this->runSession(); }
  }

  private function runSession()
  {
    // start session
    session_start();
    // check for session info, login if valid
    $this->performUserLoginAction();
  }

  /**
   * Performs a check for minimum requirements to run this application.
   * Does not run the further application when PHP version is lower than 5.3.7
   * Does include the PHP password compatibility library when PHP version lower than 5.5.0
   * (this library adds the PHP 5.5 password hashing functions to older versions of PHP)
   * @return bool Success status of minimum requirements check, default is false
   */
  private function checkRequirements()
  {
    if (version_compare(PHP_VERSION, '5.3.7', '<')) {
      echo "Sorry, Simple PHP Login does not run on a PHP version older than 5.3.7 !";
    } elseif (version_compare(PHP_VERSION, '5.5.0', '<')) {
      require_once("include/password_compatibility_library.php");
      return true;
    } elseif (version_compare(PHP_VERSION, '5.5.0', '>=')) {
      return true;
    }
    // default return
    return false;
  }

  public function doLogin()
  {
    if ($this->checkLogin()) {
      $this->login();
    }
  }

  private function performUserLoginAction()
  {
    if (isset($_GET["action"]) && $_GET["action"] == "logout") { $this->doLogout(); }
    elseif (!empty($_SESSION['username']) && ($_SESSION['logged_in'])) { $this->doSessionLogin(); }
    elseif (isset($_POST["login"])) { $this->doLogin(); }
  }

  private function doSessionLogin()                                                                                                                                                                                                                                     
  {                                                                                                                                                                                                                                                                             
    $this->logged_in = true; // not entirely sure this is useful
  }                                                                            

  public function doLogout()
  {
    $_SESSION = array();
    session_destroy();
    $this->logged_in = false;
    $this->feedback = "You were just logged out.";
  }

  public function doRegister()
  {
    if ($this->checkRegistration()) {
      $this->createNewUser();
    }
  }

  /**
   * Validates the login form data, checks if username and password are provided
   * @return bool Login form data check success state
   */
  private function checkLogin()
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

  private function login() {
    global $database;

    $result=$database->get("users",
                     array("users.username(username)",
                           "users.email(email)",
                           "users.passhash(passhash)",
                           "users.admin(is_admin)",
                           "users.superuser(is_superuser)",
                           "users.user(is_user)"),
                     array("OR" => array("users.username[=]" => $_POST['username'],"users.email[=]" => $_POST['username'])));

    if ($result) {
    // using PHP 5.5's password_verify() function to check password
      if (password_verify($_POST['password'], $result["passhash"])) {
        // write user data into PHP SESSION [a file on your server]
        $_SESSION['username'] = $result["username"];
        $_SESSION['is_user'] = $result["is_user"];
        $_SESSION['is_superuser'] = $result["is_superuser"];
        $_SESSION['is_admin'] = $result["is_admin"];
        $_SESSION['email'] = $result[""];
        $_SESSION['logged_in'] = true;
        $this->logged_in = true;
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
  private function checkRegistration()
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
  function createNewUser()
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
  public function getLoginStatus()
  {
   return $this->logged_in;
  }
}
