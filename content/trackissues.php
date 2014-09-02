<?php

function editTrackIssue() {
	global $database, $id;

        echo '<div class="padded box">';
        echo '<div class="box-header">';
        echo 'Edit Issue';
        echo '</div>';
        echo '<div class="box-body">';

        // select issues left join houses left join issuetypes
        $datas=$database->select("issues",
                array("[>]houses" => array("house" => "id"),"[>]issuetypes" => array("issuetype" => "id")),
                array("issues.id(issue_id)","houses.name(house_name)","issuetypes.type(issue_type)","issues.issuetype(typeid)","issues.issue(issue)","issues.date(date)","issues.description(description)"),
                array("issues.id" => "$id")
                );

//      $datas=$database->select("issues", "*", array( "id[=]" => "$id" ));
        $datait=$database->select("issuetypes", "*");

	if (is_array($datas)) {
        foreach($datas as $data) { //fixme: there will be only one!
                echo '<form action="index.php" class="padded" method="post">';
                echo '<input type="hidden" name="action" value="trackissues">';
                echo '<input type="hidden" name="edit" value="update">';
                echo '<input type="hidden" name="id" value="' . $data["issue_id"] . '">';
                echo '<p><span>ID:</span><span class="right">' . $data["issue_id"] . '</span></p>';
                echo '<p><span>House:</span><span class="right">' . $data["house_name"] . '</span></p>';
                echo '<p><span>Issue Type and ID:</span><span class="right">';
                echo '<select name="issuetype">';

                foreach ($datait as $dataitem) {
                        echo '<option value="';
                        echo $dataitem["id"] . '"';
                        if ($data["typeid"] == $dataitem["id"]) { echo 'selected'; }
                        echo '>' . $dataitem["type"] . '</option>';
                        }

                echo '</select></span></p>';
                echo '<p><span>Issue:</span><span class="right"><input type="text" name="issue" value="' . $data["issue"] . '" size="44"></span></p>';
                echo '<p>Description:</p>';
                echo '<textarea cols="36" rows="8" name="description">' . $data["description"] . '</textarea><br><br>';
                echo '<input type="submit" name="Edit &raquo;" value="update" maxlength="1024">';
                echo '<a href="index.php?action=trackissues" class="button right">RESET</a><br>';
                echo '</form>';
        }
	}
	else {
		die("There was an error.");
		}

        echo '</div></div>'; // end body, end panel
}



function newTrackIssue () {
	global $database;

        echo '<div class="padded box">';
        echo '<div class="box-header">';
        echo 'New Issue';
        echo '</div>';
        echo '<div class="box-body">';

        echo '<form action="index.php" method="post" class="padded">';
        echo '<input type="hidden" name="action" value="trackissues">';
        echo '<input type="hidden" name="edit" value="new">';
        echo 'House:<br>';
        echo '<select name="id">\n';
                // house types dropdown
                $datas = $database->select("houses", array( "id", "name" ));
                foreach($datas as $data) {
                        echo '<option value="' . $data["id"] . '">' . $data["name"] . '</option>\n';
                }
        echo '</select><br><br>';
        echo 'Issue Type:<br>';
        echo '<select name="issuetype"><br>';
                // issue type dropdown
                $datas = $database->select("issuetypes", array( "id", "type" ));
                foreach($datas as $data) {
                        echo '<option value="' . $data["id"] . '">' . $data["type"] . '</option>';
                }
        echo '</select><br><br>';
        echo 'Short Description:<br>';
        echo '<input name="issue" type="text" size="40" maxlength="128" >';
        echo '<br><br>';
        echo 'Issue Details:<br>';
        echo '<textarea name="description" cols="36" rows="8"></textarea><br><br>';
        echo '<input type="submit" name="Add &raquo;" value="submit" maxlength="1024">';
        echo '<a href="index.php?action=trackissues" class="button right">RESET</a>';
        echo '</form>';

        echo '</div></div>';
}

function showTrackIssueList() {
	global $database, $id;

	// select issues left join houses, left join issuetypes
	//$datas=$database->select("issues", "*");
	$datas=$database->select("issues",
		array("[>]houses" => array("house" => "id"),"[>]issuetypes" => array("issuetype" => "id")),
		array("issues.id(issue_id)","houses.name(house_name)","issuetypes.type(issue_type)","issues.issue(issue)","issues.date(date)")
		);

	echo '<div class="padded box">';
	echo '<div class="box-header">';
	echo 'Issue List';
	echo '</div>';
	echo '<div class="box-body">';

	echo '<table class="table"><thead><tr><th>Issue</th><th>House</th><th>Issue Type</th><th>Issue</th><th>Date</th><th></th></tr></thead>';
	echo '<tbody>';

	foreach ($datas as $data) {
		echo '<tr>';
		echo '<td>' . $data["issue_id"] . '</td>';
		echo '<td>' . $data["house_name"] . '</td>';
		echo '<td>' . $data["issue_type"] . '</td>';
		echo '<td>' . $data["issue"] . '</td>';
		echo '<td>' . $data["date"] . '</td>';
		echo '<td><form action="index.php" class="padded" method="post">';
		echo '<input type="hidden" name="action" value="trackissues">';
		echo '<input type="hidden" name="edit" value="edit">';
		echo '<input type="hidden" name="id" value="' . $data["issue_id"] . '">';
		echo '<button type="submit" name="edit" value="edit">Edit</button>';
		echo '</form>';
		echo '</td>';
		echo '</tr>';
	}
	
	echo '</tbody>';
	echo '</table>';

	echo '</div></div>'; // end body, end cell
}

function showTrackIssue() {
        global $database, $id;

        // select issues left join issuetracking where issues.id == issuetracking.parent
        $datas=$database->select("issuetracking",
                array("[>]issues" => array("parent" => "id")),
                array("issuetracking.item(issue_item)","issuetracking.date(track_date)"),
		array("issues.id" => $id)
                );

        echo '<div class="padded box">';
        echo '<div class="box-header">';
        echo 'Issue Tracking';
        echo '</div>';
        echo '<div class="box-body">';

        echo '<table class="table"><thead><tr><th>Item Date</th><th>Item Data</th></tr></thead>';
        echo '<tbody>';

        foreach ($datas as $data) {
                echo '<tr>';
                echo '<td>' . $data["track_date"] . '</td>';
                echo '<td>' . $data["issue_item"] . '</td>';
                echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';

        echo '</div></div>'; // end body, end cell
}


if (!isset($reentry)) { $reentry = "0"; }

// begin main column div
echo '<div class="grid-container">';

// begin 2of3 wide col
echo '<div class="grid-50">';

	showTrackIssueList();

echo '</div>'; // end col

echo '<div class="grid-50">'; // begin new column

//begin new/edit issue box

if ($reentry == "0") {
	newTrackIssue();
}

if ($reentry == "1") {
	editTrackIssue();
}

echo '</div>'; //end column div
echo '</div>'; //end main column div

if ($reentry == "1") {
echo '<div class="grid-container">';
echo '<div class="grid-100">';
	showTrackIssue();
echo '</div></div>';
}
