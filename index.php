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

//get id
if (isset($_POST['id'])){ $id= $_POST['id']; }
elseif (isset($_GET['id'])){ $id= $_GET['id']; }
else { $id = "0"; }

//get status
if (isset($_POST['status'])){ $status = $_POST['status']; }
elseif (isset($_GET['status'])){ $status = $_GET['status']; }
else { $status = "0"; }

//house/user edit
if (isset($_POST['edit'])){ $edit= $_POST['edit']; }
elseif (isset($_GET['edit'])){ $edit= $_GET['edit']; }
else { $edit = "none"; }

$flag = 0;

//admin actions
if ($action == "users")  { $flag += 1; }
if ($action == "issues") { $flag += 1; }
if ($action == "houses") { $flag += 1; }

//user actions
if ($action == "trackissues") { $flag += 1; }

if ($flag < 1) { $action = "home"; }

//issue(type) create or edit
if (isset($_POST['issue'])){ $issue= $_POST['issue']; }
else { $issue = "none"; }
if (isset($_POST['description'])){ $description= $_POST['description']; }
else { $description = "none"; }
if (isset($_POST['issuetype'])){ $issuetype= $_POST['issuetype']; }
else { $issuetype = "none"; }
if (isset($_POST['house'])){ $house= $_POST['house']; }
else { $house = "none"; }

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

include 'include/header.inc';

//admin actions

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

	include 'admin/users.php';
}

if ($action == "issues") {

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

	include 'admin/issues.php';
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

	include 'admin/houses.php';

}

if ($action == "trackissues") {
        if ($edit == "new") {
                $last_id = $database->insert("issues", array(
                        "house" => "$id",
                        "issue" => "$issue",
                        "issuetype" => "$issuetype",
                        "status" => "$status",
                        "description" => "$description"
                        ));

		//DEBUG
		//echo "<p>status is $status</p>";
		//DEBUG END

                $reentry = "0";
        }

        if ($edit == "edit") {
                $reentry="1";
        }

        if ($edit == "addtracking") {
                $database->insert("issuetracking",
                        array( "parent" => "$id", "item" => "$description")
                        );

                $reentry = "1";
        }

        if ($edit == "update") {
                $database->update("issues", array(
                       "house" => "$house",
                       "issuetype" => "$issuetype",
                       "issue" => "$issue",
                       "status" => "$status",
                       "description" => "$description"
                ),
                       array( "id" => "$id" )
                );

		//DEBUG
		//echo "<p>status is $status</p>";
		//DEBUG END
		
                $reentry = "0";
        }


        if ($edit == "search") {
                $reentry = "1";
        }

        include 'content/trackissues.php';
}


include 'include/footer.inc';

?>
