<?php

// add mysql.php, this starts medoo()
include 'include/mysql.php';

// Read the form values
//get action
if (isset($_GET["action"])) { $action = $_GET["action"]; }
if (isset($_POST["action"])) { $action = $_POST["action"]; }

//get page
if (isset($_GET["page"])) { $page = $_GET["page"]; }
if (isset($_POST["page"])) { $page = $_POST["page"]; }

//get search
if (isset($_GET["search"])) { $search = $_GET["search"]; }
if (isset($_POST["search"])) { $search = $_POST["search"]; }

$flag = 0;
if (!isset($action)) { $action = "home"; }
if (!isset($page)) { $page = "1"; }
if (!isset($search)) { $search = "none"; }

if ($action == "users") { $flag += 1; }
if ($action == "editissues") { $flag += 1; }
if ($action == "houses") { $flag += 1; }
if ($action == "trackissues") { $flag += 1; }
if ($action == "home") { $flag += 1; }

if ($flag < 1) { $action = "home"; }

//defaults
if (isset($_POST['name'])) { $name= $_POST['name']; }
else { $name = "none"; }

if (isset($_POST['id'])){ $id= $_POST['id']; }
else { $id = "none"; }

//issue create or edit
if (isset($_POST['issue'])){ $issue= $_POST['issue']; }
else { $issue = "none"; }
if (isset($_POST['description'])){ $description= $_POST['description']; }
else { $description = "none"; }
if (isset($_POST['issuetype'])){ $issuetype= $_POST['issuetype']; }
else { $issuetype = "none"; }

//house create
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

//house/user edit
if (isset($_POST['edit'])){ $edit= $_POST['edit']; }
else { $edit = "none"; }

// if (isset($_POST['action'])){ $action= $_POST['action']; }
// else { $action = "none"; }

//success flag (not used)
$success = 0;

//set a standard selected item for the menu
$selected = "home";

include 'include/header.inc';

if ($action == "home")  { include 'content/home.php'; }

if ($action == "users") {

	if ($edit == "new") {
		$last_id = $database->insert("users", array(
		"name" => "$name",
		"username" => "$username",
		"admin" => "$admin",
		"superuser" => "$superuser",
		"user" => "$user"
		));

		$reentry = "1";
	}

	include 'content/users.php';
}

if ($action == "trackissues") {
	if ($edit == "new") {
		$last_id = $database->insert("issues", array(
			"house" => "$id",
			"issue" => "$issue",
			"issuetype" => "$issuetype",
			"description" => "$description"
			));

		$reentry = "0";
	}

        if ($edit == "edit") {
                $reentry="1";
        }

	if ($edit == "update") {
		$database->insert("issuetracking",
			array( "parent" => "$id", "item" => "$description")
			);

		$reentry = "1";
	}

	if ($edit == "search") {
                $reentry = "1";
        }

	include 'content/trackissues.php';
}

if ($action == "editissues") {

	if ($edit == "new") {
		$lastid=$database->insert("issuetypes", array(
		"type" => "$issuetype",
		"description" => "$description"
		));

		$reentry = "0";
	}

	if ($edit == "edit") {
		$reentry = "1";
	}


	if ($edit == "update") {
		$database->update("issuetypes",
			array("type" => "$issuetype", "description" => "$description"),
			array( "id" => "$id" )
			);

		$reentry = "0";
	}

	include 'content/editissues.php';
}

if ($action == "houses") {

	if ($edit == "new") {
		$last_id = $database->insert("houses", array(
		"name" => "$name",
		"address1" => "$address1",
		"address2" => "$address2",
		"postcode" => "$postcode",
		"town" => "$town"
		));

		$reentry="0";
	}

	if ($edit == "update") {

		$database->update("houses", array(
			"name" => $name,
			"address1" => $address1,
			"address2" => $address2,
			"postcode" => $postcode,
			"town" => $town),
			array( "id[=]" => $id )
		);

		$reentry = "0";
	}

	if ($edit == "delete") {
		$database->delete("houses", array( "AND" => array( "id" => "$id" ) ));
		$reentry = "0";
	}

	if ($edit == "show") {
		$datas=$database->select("houses", "*", array( "id" => "$id" ));
		//$data=$database->select("houses", "*", array( "id" => "$id" ));

		foreach ($datas as $data) {
			$id = $data["id"];
			$name = $data["name"];
			$address1 = $data["address1"];
			$address2 = $data["address2"];
			$postcode = $data["postcode"];
			$town = $data["town"];
			$description = $data["description"];
		}

		$reentry = "1";
	}

	include 'content/houses.php';

}

include 'include/footer.inc';

?>
