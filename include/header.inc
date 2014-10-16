<?php

echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">';
echo '<html>';

echo '<head>';
echo '<meta charset="utf-8">';
echo '<title>Issuetracker</title>';
echo '<meta http-equiv="X-UA-Compatible" content="IE=edge">';
echo '<meta name="viewport" content="width=device-width, initial-scale=1">';
echo '<meta name="description" content="">';
echo '<meta name="author" content="Unknown">';
echo '<!-- fontawesome etc -->';
echo '<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">';
echo '<!-- Latest compiled and minified CSS -->';
echo '<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">';
echo '<!-- Optional theme -->';
echo '<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css"> -->';
echo '<link rel="icon" href="icons/favicon.ico">';
echo '</head>';

echo '<body>';
echo '  <div class="navbar navbar-default">';
echo '    <div class="container">';
echo '      <div class="navbar-header">';
echo '        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">';
echo '          <span class="sr-only">Toggle navigation</span>';
echo '          <span class="icon-bar"></span>';
echo '          <span class="icon-bar"></span>';
echo '          <span class="icon-bar"></span>';
echo '        </button>';
echo '        <a class="navbar-brand" href="#">Issuetracker</a>';
echo '      </div>';
echo '      <div class="navbar-collapse collapse">';
echo '        <ul class="nav navbar-nav">';

if ($_SESSION['is_admin']) {
  echo '          <li class="dropdown">';
  echo '            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Admin <span class="caret"></span></a>';
  echo '            <ul class="dropdown-menu" role="menu">';
  echo '              <li';

  if ($action == "users") { echo ' class="active" '; }

  echo '                 ><a href="index.php?action=users">';
  echo '                 <i class="fa fa-users"></i>&nbsp;User Admin</a></li>';
  echo '            </ul>';
  echo '          </li>';
}

if ($_SESSION['is_superuser']) {
  echo '          <li class="dropdown">';
  echo '            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Poweruser <span class="caret"></span></a>';
  echo '            <ul class="dropdown-menu" role="menu">';
  echo '              <li';

  if ($action == "houses") { echo ' class="active" '; }

  echo '                 ><a href="index.php?action=houses">';
  echo '                 <i class="fa fa-building"></i>&nbsp;House Admin</a></li>';
  echo '              <li';

  if ($action == "issues") { echo ' class="active "'; }

  echo '                 ><a href="index.php?action=issues">';
  echo '                 <i class="fa fa-folder-open"></i>&nbsp;Issue Type Admin</a></li>';
  echo '            </ul>';
  echo '          </li>';
}

if ($_SESSION['is_user']) {
  echo '          <li';

  if ($action == "trackissues") { echo ' class="active" '; }

  echo '            ><a href="index.php?action=trackissues">';
  echo '            <i class="fa fa-check-square"></i>&nbsp;Track Issues</a>';
  echo '          </li>';
}

echo '        </ul>';
echo '          <ul class="nav navbar-nav pull-right">';

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

echo '          </ul>';
echo '        </div><!--/.nav-collapse -->';
echo '      </div>';
echo '    </div>';

