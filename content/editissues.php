<?php

function updateIssueType() {
	//include globals $database and $id
	global $database;
	global $id;
	

        echo '<div class="panel panel-default">';
        echo '<div class="panel-heading">';
        echo 'Update Issue Type';
        echo '</div>';
        echo '<div class="panel-body">';

        $datas = $database->select("issuetypes","*",array( "id[=]" => $id ));

        foreach ($datas as $data) {
                echo '<form action="index.php" method="post" class="padded">';
                echo '<input type="hidden" name="action" value="editissues">';
                echo '<input type="hidden" name="edit" value="update">';
                echo '<input type="hidden" name="id" value="' . $data["id"] . '">';

                echo 'Issue Short Description:<br>';
                echo '<input name="issuetype" type="text" size="40" maxlength="128" value="' . $data["type"] . '">';
                echo '<br><br>'; 
                echo 'Issue Long Description:<br>';
                echo '<textarea name="description" cols="40" rows="8">' . $data["description"] . '</textarea><br><br>';
                echo '<input class="btn btn-default" type="submit" name="Add &raquo;" value="Update" maxlength="1024">';
                echo '<a class="btn btn-primary pull-right" href="index.php?action=editissues">Reset</a>';
                echo '</form>';  
        }

        echo '</div></div>';
}

function newIssueType() {
        echo '<div class="panel panel-default">';
        echo '  <div class="panel-heading">';
        echo 'New Issue Type';
        echo '  </div>';
        echo '<div class="panel-body">';

        echo '<form action="index.php" method="post" class="padded">';
        echo '<input type="hidden" name="action" value="editissues">';
        echo '<input type="hidden" name="edit" value="new">';

        // issue types dropdown
        echo 'Issue Short Description:<br>';
        echo '<input name="issuetype" type="text" size="40" maxlength="128" >';
        echo '<br><br>';
        echo 'Issue Long Description:<br>';
        echo '<textarea name="description" cols="40" rows="8"></textarea><br><br>';
        echo '<input class="btn btn-default" type="submit" name="Add &raquo;" value="New" maxlength="1024">';
        echo '<a class="btn btn-primary pull-right" href="index.php?action=editissues">Reset</a>';
        echo '</form>';

        echo '</div></div>';
}

function issueTypeList() {
	global $database;
	global $page;

	echo '<div class="panel panel-default">';
	echo '<div class="panel-heading">';
	echo 'Issue Type List';
	echo '</div>';
	echo '<div class="panel-body">';

	$datas = $database->select("issuetypes", "*", array("LIMIT" => array(($page*5)-5,5)));

        echo '<table class="table table-striped">';
        echo '<thead><tr><th>ID</th><th>Issue Type</th><th>Description</th><th></th></tr></thead>';
        echo '<tbody>'; 

	foreach($datas as $data) {
	        echo '<tr>';
	        echo '<td>' . $data["id"] . '</td>';
	        echo '<td>' . $data["type"] . '</td>';
	        echo '<td>' . $data["description"] . '</td>';
	        echo '<td><form action="index.php?page=' . $page . '" class="padded" method="post">';
	        echo '<input type="hidden" name="action" value="editissues">';
	        echo '<input type="hidden" name="id" value="' . $data["id"] . '">';
	        echo '<button class="btn btn-default" type="submit" name="edit" value="edit">Edit</button>';
	        echo '</form></td>';
	        echo '</tr>';
	}

        echo '</tbody>';
        echo '</table>';

        // fetch count of all rows in issuetypes
        $count = $database->count("issuetypes");
                // optional: $where: array("column" => "value")

	paginate($count);

	echo '</div></div>'; //end box-body, end box
}

/*****************
 * start of html *
 *****************/

if (!isset($reentry)) { $reentry = "0"; }

echo '<div class="container-fluid">';
echo '<div class="row">';
echo '<div class="col-sm-4">';

if ($reentry == "1") {
	updateIssueType();
}

if ($reentry == "0") {
	newIssueType();
}

echo '</div>';

echo '<div class="col-sm-8">';

	issueTypeList();

echo '</div>'; // end grid box
echo '</div>'; // end grid container
echo '</div>'; // end container

?>
