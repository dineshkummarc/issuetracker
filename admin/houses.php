<?php

function showHouses() {
	global $database;
	global $page;

	echo '<div class="panel panel-default">';
	echo '<div class="panel-heading">';
	echo 'Houses';
	echo '</div>';
	echo '<div class="panel-body">';

	// fetch all house data
	$datas=$database->select("houses",
		array("name", "address1", "address2", "postcode", "town", "id"),
		array("LIMIT" => array(($page*5)-5,5))
		);

//DEBUG
//echo '<p>pages is ' . $pages . '</p>';
//echo '<p>page is ' . $page . '</p>';
//echo '<p>count is ' . $count . '</p>';
//echo '<p>' . $database->last_query() . '</p>';
//DEBUG END

	echo '<table class="table table-striped">';
	echo '<thead><tr><th>ID</th><th>Name</th><th>Address</th><th></th></tr></thead>';
	echo '<tbody>';

	// print all house data
	foreach($datas as $data) {
	echo '<tr>';
	echo '<td>' . $data["id"] . '</td><td>' . $data["name"] . '</td>';
	        echo '<td>';
	        echo $data["address1"] . '<br>';
	        if (isset($data["address2"])) { echo $data["address2"] . '<br>'; }
	        echo $data["postcode"] . '&nbsp;';
	        echo $data["town"] . '<br>';
	        echo '</td>';
	//edit/delete taloyhtio form
	        echo '<td><form action="index.php" class="padded" method="post">';
	        echo '<input type="hidden" name="action" value="houses">';
	        echo '<input type="hidden" name="id" value="' . $data["id"] . '">';
	//      echo '<button class="btn btn-default" type="submit" name="edit" value="edit">Edit</button>';
	//      echo '<button class="btn btn-default" type="submit" name="edit" value="delete">Delete</button>';
	        echo '<button class="btn btn-default" type="submit" name="edit" value="show">Manage House</button>';
	        echo '</form>';
	        echo '</td>';
	        echo '</tr>';
	}

	echo '</tbody>';
	echo '</table>';

        // fetch count of all rows in houses
        $count = $database->count("houses");

        paginate($count);

	echo '</div></div>';
}

function newHouse() {
        echo '<div class="panel panel-default">';
        echo '<div class="panel-heading">';
        echo 'New House';
        echo '</div>';
        echo '<div class="panel-body">';

        // add new house form
        echo '<form action="index.php" method="post" class="form-vertical">';
        echo '<p>House Name:</p>';
        echo '<p><input name="name" type="text" size="44" maxlength="50" ></p>';
        echo '<br>';
        echo '<p>Address1:</p>';
        echo '<p><input name="address1" type="text" size="44" maxlength="50"></p>';
        echo '<br>';
        echo '<p>Address2:</p>';
        echo '<p><input name="address2" type="text" size="44" maxlength="32"></p>';
        echo '<br>';
        echo '<p>Postcode:</p>';
        echo '<p><input name="postcode" type="text" size="44" maxlength="32"></p>';
        echo '<br>';
        echo '<p>Town:</p>';
        echo '<p><input name="town" type="text" size="44" maxlength="32"></p>';
        echo '<br>';
        echo '<input type="hidden" name="action" value="houses">';
        echo '<input type="hidden" name="edit" value="new">';
        echo '<input class="btn btn-default" type="submit" name="Add &raquo;" value="submit" maxlength="1024">';
        echo '<a href="index.php?action=houses" class="btn btn-primary pull-right">Reset</a>';
        echo '</form>';

        echo '</div></div>'; //end body, end panel
}

function updateHouse() {
  global $database, $id;

  $data=$database->get("houses",
    array("id", "name", "address1", "address2", "postcode", "town", "description", "active"),
    array("houses.id" => $id)
    );

  echo '<div class="panel panel-default">';
  echo '<div class="panel-heading">';
  echo 'Update House';
  echo '</div>';
  echo '<div class="panel-body">';

  // edit house form -->
  echo '<form action="index.php" method="post" class="padded">';
  echo '<input type="hidden" name="action" value="houses">';
  echo '<input type="hidden" name="edit" value="update">';
  echo '<input type="hidden" name="id" value="' . $id . '">';
  echo '<p><span class="left">House Name:</span>';
  echo '<span class="pull-right"><input name="name" type="text" size="44" maxlength="50" value="' . $data["name"] . '"></span>';
  echo '</p>';
  echo '<br><br>';
  echo '<p><span class="left">Address1:</span>';
  echo '<span class="pull-right"><input name="address1" type="text" size="44" maxlength="50" value="' . $data["address1"] . '"></span>';
  echo '</p>';
  echo '<br><br>';
  echo '<p><span class="left">Address2:</span>';
  echo '<span class="pull-right"><input name="address2" type="text" size="44" maxlength="32" value="' . $data["address2"] . '"></span>';
  echo '</p>';
  echo '<br><br>';
  echo '<p><span class="left">Postcode:</span>';
  echo '<span class="pull-right"><input name="postcode" type="text" size="44" maxlength="32" value="' . $data["postcode"] . '"></span>';
  echo '</p>';
  echo '<br><br>';
  echo '<p><span class="left">Town:</span><br>';
  echo '<span class="pull-right"><input name="town" type="text" size="44" maxlength="32" value="' . $data["town"] . '"></span>';
  echo '</p>';
  echo '<br><br>';
  echo '<input class="btn btn-default" type="submit" name="Update &raquo;" value="submit" maxlength="1024">';
  echo '<a href="index.php?action=houses" class="btn btn-primary pull-right">Reset</a>';
  echo '</form>';

  echo '</div></div>'; //end panel-body, end box
}

function showHouseIssues() {
	global $database, $id;

        echo '<div class="panel panel-default">';
        echo '<div class="panel-heading">';
        echo 'House Issues';
        echo '</div>';
        echo '<div class="panel-body">';

        echo '<table><thead><tr><th></th><th></th><th></th></tr></thead>';

        $datas = $database->select("issues","*",array( "house[=]" => $id ));

        echo '<table class="table table-striped">';
        echo '<thead><tr><th>ID</th><th>House ID</th><th>Issue</th><th>Description</th></tr></thead>';
        echo '<tbody>';

        foreach($datas as $data) {
                echo '<tr>';  
                echo '<td>' . $data["id"] . '</td>';
                echo '<td>' . $data["house"] . '</td>';
                echo '<td>' . $data["issue"] . '</td><td>' . $data["description"] . '</td>';
                echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';

        echo '</div></div>'; // end panel-body, end box
}

function showHouse() {
  global $database, $id;
  $datas=$database->select("houses",
    array("id", "name", "address1", "address2", "postcode", "town", "description", "active"),
    array("houses.id" => $id)
    );
}

if (!isset($reentry)) { $reentry = "0"; }

/****************************
 * if edit is set, do stuff *
 ****************************/
if ($edit == "show") {
  $reentry = "1";
}

if ($edit == "new") {
  $last_id = $database->insert("houses", array(
    "name" => "$name",
    "address1" => "$address1",
    "address2" => "$address2",
    "postcode" => "$postcode",
    "town" => "$town"));
}

if ($edit == "update") {
  $database->update("houses", array(
    "name" => $name,
    "address1" => $address1,
    "address2" => $address2,
    "postcode" => $postcode,
    "town" => $town),
    array( "id[=]" => $id ));
}

if ($edit == "delete") {
   $database->delete("houses", array( "AND" => array( "id" => "$id" ) ));
}

/**************
 * start html *
 **************/

echo '<div class="container-fluid">';

if ($reentry == "0") {
  echo '<div class="col-md-4">';
  newHouse();
  echo '</div>'; // end column
  echo '<div class="col-md-8">';
  showHouses();
  echo '</div>'; // end column
}

if ($reentry == "1") {
  echo '<div class="col-md-4">';
  updateHouse();
  echo '</div>'; // end column
  echo '<div class="col-md-8">';
  showHouseIssues();
  echo '</div>'; // end column
}

echo '</div>'; // end container

?>
