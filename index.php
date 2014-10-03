<?php

// add mysql.php, this starts medoo()
// add functions.php
require_once 'include/mysql.php';
require_once 'include/functions.php';

// Read the form values

//get action
if (isset($_POST["action"])) { $action = $_POST["action"]; }
elseif (isset($_GET["action"])) { $action = $_GET["action"]; }
else { $action = "home"; }

//get page
if (isset($_POST["page"])) { $page = $_POST["page"]; }
elseif (isset($_GET["page"])) { $page = $_GET["page"]; }
else { $page = "1"; }

//get search
if (isset($_POST["search"])) { $search = $_POST["search"]; }
elseif (isset($_GET["search"])) { $search = $_GET["search"]; }
else { $search = "none"; }

//get id (or leave null)
if (isset($_POST['id'])){ $id= $_POST['id']; }
elseif (isset($_GET['id'])){ $id= $_GET['id']; }
else { $id = ""; }

//get status (or leave null)
if (isset($_POST['status'])){ $status = $_POST['status']; }
elseif (isset($_GET['status'])){ $status = $_GET['status']; }
else { $status = ""; }

//house/user edit
if (isset($_POST['edit'])){ $edit= $_POST['edit']; }
elseif (isset($_GET['edit'])){ $edit= $_GET['edit']; }
else { $edit = "none"; }

//issue(type) create or edit
if (isset($_POST['issue'])){ $issue= $_POST['issue']; }
else { $issue = "none"; }
if (isset($_POST['description'])){ $description= $_POST['description']; }
else { $description = "none"; }
if (isset($_POST['issuetype'])){ $issuetype= $_POST['issuetype']; }
else { $issuetype = "none"; }
if (isset($_POST['house'])){ $house= $_POST['house']; }
else { $house = "none"; }
if (isset($_POST['parent'])){ $parent= $_POST['parent']; }
else { $parent = "none"; }

//house create/update
if (isset($_POST['name'])){ $name= $_POST['name']; }
else { $address1 = "none"; }
if (isset($_POST['address1'])){ $address1= $_POST['address1']; }
else { $address1 = "none"; }
if (isset($_POST['address2'])){ $address2= $_POST['address2']; }
else { $address2 = "none"; }
if (isset($_POST['postcode'])){ $postcode= $_POST['postcode']; }
else { $postcode = "none"; }
if (isset($_POST['town'])){ $town= $_POST['town']; }
else { $town = "none"; }

//user create
if (isset($_POST['username'])){ $username= $_POST['username']; }
else { $username = "none"; }
if (isset($_POST['admin'])) { $admin = "1"; }
else { $admin = "0"; }
if (isset($_POST['superuser'])) { $superuser = "1"; }
else { $superuser = "0"; }
if (isset($_POST['user'])){ $user= "1"; }
else { $user = "0"; }

include 'include/header.inc';

//admin actions
if ($action == "users") { include 'admin/users.php'; }
elseif ($action == "issues") { include 'admin/issues.php'; }
elseif ($action == "houses") { include 'admin/houses.php'; }
//user actions
elseif ($action == "trackissues") { include 'content/trackissues.php'; }
//default actions
else { include 'content/home.php'; }


include 'include/footer.inc';

?>
