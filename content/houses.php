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

	$count=count($datas);
	$pages=$count/5;

//DEBUG
//echo '<p>pages is ' . $pages . '</p>';
//echo '<p>page is ' . $page . '</p>';
//echo '<p>count is ' . $count . '</p>';
//DEBUG END

	echo '<table class="table horizontal-border">';
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

$min = 0;
$max = $pages+1;
$start = $pages - 5;
if ($start < 0) { $start = 1; }
for ( ; $start <= $max ; $start++ ) {
        echo '&nbsp<a href="index.php?action=houses&page=' . $start . '">Page ' . $start . '</a>';
        }

	echo '</div></div>';

}

function newHouse() {
        echo '<div class="panel panel-default">';
        echo '<div class="panel-heading">';
        echo 'New House';
        echo '</div>';
        echo '<div class="panel-body">';

        // add new house form
        echo '<form action="index.php" method="post" class="padded">';
        echo '<p><span class="left">House Name:</span>';
        echo '<span class="right"><input name="name" type="text" size="44" maxlength="50" ></span>';
        echo '</p>';
        echo '<br><br>';
        echo '<p><span class="left">Address1:</span>';
        echo '<span class="right"><input name="address1" type="text" size="44" maxlength="50"></span>';
        echo '</p>';
        echo '<br><br>';
        echo '<p><span class="left">Address2:</span>';
        echo '<span class="right"><input name="address2" type="text" size="44" maxlength="32"></span>';
        echo '</p>';
        echo '<br><br>';
        echo '<p><span class="left">Postcode:</span>';
        echo '<span class="right"><input name="postcode" type="text" size="44" maxlength="32"></span>';
        echo '</p>';
        echo '<br><br>';
        echo '<p><span class="left">Town:</span><br>';
        echo '<span class="right"><input name="town" type="text" size="44" maxlength="32"></span>';
        echo '</p>';
        echo '<br><br>';
        echo '<input type="hidden" name="action" value="houses">';
        echo '<input type="hidden" name="edit" value="new">';
        echo '<input class="btn btn-default" type="submit" name="Add &raquo;" value="submit" maxlength="1024">';
        echo '<a href="index.php?action=houses" class="btn btn-default right">RESET</a>';
        echo '</form>';

        echo '</div></div>'; //end body, end panel
}

function updateHouse() {
	global $name, $address1, $address2, $postcode, $town, $id;
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
        echo '<span class="right"><input name="name" type="text" size="44" maxlength="50" value="' . $name . '"></span>';
        echo '</p>';
        echo '<br><br>';
        echo '<p><span class="left">Address1:</span>';
        echo '<span class="right"><input name="address1" type="text" size="44" maxlength="50" value="' . $address1 . '"></span>';
        echo '</p>';
        echo '<br><br>';
        echo '<p><span class="left">Address2:</span>';
        echo '<span class="right"><input name="address2" type="text" size="44" maxlength="32" value="' . $address2 . '"></span>';
        echo '</p>';
        echo '<br><br>';
        echo '<p><span class="left">Postcode:</span>';
        echo '<span class="right"><input name="postcode" type="text" size="44" maxlength="32" value="' . $postcode . '"></span>';
        echo '</p>';
        echo '<br><br>';
        echo '<p><span class="left">Town:</span><br>';
        echo '<span class="right"><input name="town" type="text" size="44" maxlength="32" value="' . $town . '"></span>';
        echo '</p>';
        echo '<br><br>';
        echo '<input class="btn btn-default" type="submit" name="Update &raquo;" value="submit" maxlength="1024">';
        echo '<a href="index.php?action=houses" class="btn btn-default right">RESET</a>';
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


if (!isset($reentry)) { $reentry = "0"; }

/**************
 * start html *
 **************/

echo '<div class="container-fluid">';

if ($reentry == "0") {
  echo '<div class="col-md-3">';
  newHouse();
  echo '</div>'; // end column
  echo '<div class="col-md-9">';
  showHouses();
  echo '</div>'; // end column
  }

if ($reentry == "1") {
  echo '<div class="col-md-3">';
  updateHouse();
  echo '</div>'; // end column
  echo '<div class="col-md-9">';
  showHouseIssues();
  echo '</div>'; // end column
  }

echo '</div>'; // end container

?>
