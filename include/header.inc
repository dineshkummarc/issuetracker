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

<!-- css tweaks -->
<link rel="stylesheet" href="css/unsemantic-grid-responsive-no-ie7.css" type="text/css">
<link rel="stylesheet" href="css/style.css" type="text/css">

<link rel="icon" href="icons/favicon.ico">

</head>

<!-- page body -->
<body>

<!-- top menu div -->
<nav>
	<ul>
		<li><a class="button <?php if ($selected == "users") echo 'active'; ?>" href="index.php?action=users">
				<i class="fa fa-home"></i>&nbsp;User Admin</a></li>
		<li><a class="button <?php if ($selected == "houses") echo 'active'; ?>" a href="index.php?action=houses">
				<i class="fa fa-gear"></i>&nbsp;House Admin</a></li>
		<li><a class="button <?php if ($selected == "editissues") echo 'active'; ?>" a href="index.php?action=editissues">
				<i class="fa fa-gear"></i>&nbsp;Manage Issues</a></li>
		<li><a class="button <?php if ($selected == "trackissues") echo 'active'; ?>" a href="index.php?action=trackissues">
				<i class="fa fa-gear"></i>&nbsp;Track Issues</a></li>
	</ul>
</nav>

