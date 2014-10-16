<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html>

<head>

<meta charset="utf-8">
<title>Issuetracker</title>

<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="Unknown" >

<!-- fontawesome etc -->
<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">

<!-- Optional theme -->
<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css"> -->

<link rel="icon" href="icons/favicon.ico">

</head>

<!-- page body -->
<body>

      <div class="navbar navbar-default">
        <div class="container">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Issuetracker</a>
          </div>
          <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Admin Tasks <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                <li <?php if ($action == "users") echo 'class="active"'; ?> ><a href="index.php?action=users">
                                <i class="fa fa-users"></i>&nbsp;User Admin</a></li>
                <li <?php if ($action == "houses") echo 'class="active"'; ?> ><a href="index.php?action=houses">
                                <i class="fa fa-building"></i>&nbsp;House Admin</a></li>
                <li <?php if ($action == "issues") echo 'class="active"'; ?> ><a href="index.php?action=issues">
                                <i class="fa fa-folder-open"></i>&nbsp;Issue Type Admin</a></li>

                </ul>
              </li>
              <li <?php if ($action == "trackissues") echo 'class="active"'; ?> ><a href="index.php?action=trackissues">
                 <i class="fa fa-check-square"></i>&nbsp;Track Issues</a>
              </li>
             </ul>

<ul class="nav navbar-nav pull-right">
<?php
  if (!empty($_SESSION['username']) && ($_SESSION['logged_in'])) {
    echo "<p class=\"navbar-text\">Welcome, " . $_SESSION['username'] . "</p>";
    echo "<li ";
    if ($action == "logout") { echo 'class="active"'; }
    echo "><a href=\"index.php?action=logout\"><i class=\"fa fa-gear\"></i>&nbsp;Logout</a></li>";
  }
  else {
    echo "<li ";
    if ($action == "login")  { echo 'class="active"'; }
    echo "><a href=\"index.php?action=login\"><i class=\"fa fa-gear\"></i>&nbsp;Login</a></li>";
    echo "<li ";
    if ($action == "register")  { echo 'class="active"'; }
    echo "><a href=\"index.php?action=register\"><i class=\"fa fa-gear\"></i>&nbsp;register</a></li>";
  }
?>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>

