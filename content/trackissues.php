<?php

if (!isset($reentry)) { $reentry = "0"; }

// begin main column div
echo '<div class="grid-container">';

// begin 2of3 wide col
echo '<div class="grid-66">';

// browse issues DB -->

// select issues left join houses, left join issuetypes
//$datas=$database->select("issues", "*");
$datas=$database->select("issues",
	array("[>]houses" => array("house" => "id"),"[>]issuetypes" => array("issuetype" => "id")),
	array("issues.id(issue_id)","houses.name(house_name)","issuetypes.type(issue_type)","issues.issue(issue)","issues.date(date)")
	);

echo '<div class="cell panel">';
echo '<div class="header">';
echo ' <p>Issue List:</p>';
echo '</div>';
echo '<div class="body">';

echo '<table class="table horizontal-border"><thead><tr><th>ID</th><th>House</th><th>Issue Type</th><th>Issue</th><th>Date</th><th></th></tr></thead>';
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

echo '</div>'; // end col

echo '<div class="grid-33">'; // begin new column

//begin new/edit issue box

if ($reentry == "0") {
echo '<div class="cell panel">';
echo '<div class="header">';
echo ' <p>New Issue</p>';
echo '</div>';
echo '<div class="body">';

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
	echo '<textarea name="description" cols="40" rows="8"></textarea><br><br>';
	echo '<input type="submit" name="Add &raquo;" value="submit" maxlength="1024">';
	echo '<a href="index.php?action=editissues" class="button right">RESET</a>';
	echo '</form>';

	echo '</div></div>';
}

if ($reentry == "1") {
	echo '<div class="cell panel">';
	echo '<div class="header">';
	echo ' <p>Edit Issue:</p>';
	echo '</div>';
	echo '<div class="body">';

	// select issues left join houses left join issuetypes
	$datas=$database->select("issues",
		array("[>]houses" => array("house" => "id"),"[>]issuetypes" => array("issuetype" => "id")),
		array("issues.id(issue_id)","houses.name(house_name)","issuetypes.type(issue_type)","issues.issuetype(typeid)","issues.issue(issue)","issues.date(date)","issues.description(description)"),
		array("issues.id" => "$id")
		);

//	$datas=$database->select("issues", "*", array( "id[=]" => "$id" ));
	$datait=$database->select("issuetypes", "*");

	foreach($datas as $data) { //fixme: there will be only one!
		echo '<form action="index.php" class="padded" method="post">';
		echo '<input type="hidden" name="action" value="trackissues">';
		echo '<input type="hidden" name="edit" value="update">';
		echo '<input type="hidden" name="id" value="' . $data["issue_id"] . '">';
		echo '<p><span>ID:</span><span class="right">' . $data["issue_id"] . '</span></p><br>';
		echo '<p><span>House:</span><span class="right">' . $data["house_name"] . '</span></p><br>';
		echo '<p><span>Issue Type and ID:</span><span class="right">';
		echo '<select name="issuetype">';

		foreach ($datait as $dataitem) {
			echo '<option value="';
			echo $dataitem["id"] . '"';
			if ($data["typeid"] == $dataitem["id"]) { echo 'selected'; }
			echo '>' . $dataitem["type"] . '</option>';
			}

		echo '</select></span></p><br>';
		echo '<p><span>Issue:</span><span class="right"><input type="text" name="issue" value="' . $data["issue"] . '" size="44"></span></p><br>';
		echo '<p>Description:</p>';
		echo '<textarea cols="40" rows="8" name="description">' . $data["description"] . '</textarea><br><br>';
		echo '<input type="submit" name="Edit &raquo;" value="update" maxlength="1024">';
		echo '<a href="index.php?action=editissues" class="button right">RESET</a><br>';
		echo '</form>';
	}

	echo '</div></div>'; // end body, end panel
}

echo '</div>'; //end column div
echo '</div>'; //end main column div
