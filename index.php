<?php

// add mysql.php, this starts medoo()
// add functions.php
require_once 'include/mysql.php';
require_once 'include/functions.php';
require_once 'include/login.php';

// run the application
$session = new Session();

// Read the form values

if (isset($_POST["action"])) { $action = $_POST["action"]; }
elseif (isset($_GET["action"])) { $action = $_GET["action"]; }
else { $action = "home"; }

if (isset($_POST["page"])) { $page = $_POST["page"]; }
elseif (isset($_GET["page"])) { $page = $_GET["page"]; }
else { $page = "1"; }

if (isset($_POST["search"])) { $search = $_POST["search"]; }
elseif (isset($_GET["search"])) { $search = $_GET["search"]; }
else { $search = "none"; }

if (isset($_POST['issuetype'])) { $issuetype= $_POST['issuetype']; }
elseif (isset($_GET['issuetype'])){ $issuetype= $_GET['issuetype']; }
else { $issuetype = ""; }

if (isset($_POST['house'])) { $house= $_POST['house']; }
elseif (isset($_GET['house'])) { $house= $_GET['house']; }
else { $house = ""; }

if (isset($_POST['status'])){ $status= $_POST['status']; }
elseif (isset($_GET['status'])){ $status= $_GET['status']; }
else { $status = ""; }

if (isset($_POST['id'])){ $id= $_POST['id']; }
elseif (isset($_GET['id'])){ $id= $_GET['id']; }
else { $id = ""; }

//get status (or leave null)
if (isset($_POST['status'])){ $status = $_POST['status']; }
elseif (isset($_GET['status'])){ $status = $_GET['status']; }
else { $status = ""; }

//get edit (or leave null)
if (isset($_POST['edit'])){ $edit= $_POST['edit']; }
elseif (isset($_GET['edit'])){ $edit= $_GET['edit']; }
else { $edit = ""; }

//issue(type) create or edit
if (isset($_POST['issue'])){ $issue= $_POST['issue']; }
else { $issue = ""; }
if (isset($_POST['description'])){ $description= $_POST['description']; }
else { $description = ""; }
if (isset($_POST['parent'])){ $parent= $_POST['parent']; }
else { $parent = ""; }

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

//start HTML
include 'include/header.inc';

//admin actions
if ($action == "users") { include 'admin/users.php'; }
elseif ($action == "issues") { include 'admin/issues.php'; }
elseif ($action == "houses") { include 'admin/houses.php'; }
//user actions
elseif ($action == "trackissues") { include 'content/trackissues.php'; }
elseif ($action == "login") { include 'content/login.php'; }
//session actions
elseif ($action == "logout") { include 'content/login.php'; }
elseif ($action == "register") { include 'content/login.php'; }
elseif ($action == "doregister") { include 'content/login.php'; }
//default actions
else { include 'content/home.php'; }

include 'include/footer.inc';

?>
