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
                                <i class="fa fa-home"></i>&nbsp;House Admin</a></li>
                <li <?php if ($action == "issues") echo 'class="active"'; ?> ><a href="index.php?action=issues">
                                <i class="fa fa-folder-open"></i>&nbsp;Issue Admin</a></li>

                </ul>
              </li>
                <li <?php if ($action == "trackissues") echo 'class="active"'; ?> ><a href="index.php?action=trackissues">
                                <i class="fa fa-gear"></i>&nbsp;Track Issues</a></li>
<!--          <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                  <li><a href="#">Action</a></li>
                  <li><a href="#">Another action</a></li>
                  <li><a href="#">Something else here</a></li>
                  <li class="divider"></li>
                  <li class="dropdown-header">Nav header</li>
                  <li><a href="#">Separated link</a></li>
                  <li><a href="#">One more separated link</a></li>
                </ul>
              </li> -->

            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>


