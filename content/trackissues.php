<?php

function editTrackIssue() {
	global $database, $id;

/* if $edit is search, then newTrackIssue()
   else if $edit is edit, then editTrackIssue
 */

        // select issues left join houses left join issuetypes
        $datas=$database->select("issues",
                array("[>]houses" => array("house" => "id"),"[>]issuetypes" => array("issuetype" => "id")),
                array("houses.id(house_id)","houses.name(house_name)","issuetypes.type(issue_type)","issues.id(issue_id)","issues.issuetype(typeid)","issues.issue(issue)","issues.date(date)","issues.description(description)"),
                array("issues.id" => "$id")
                );

//      $datas=$database->select("issues", "*", array( "id[=]" => "$id" ));
        $datait=$database->select("issuetypes", "*");
        $dataho=$database->select("houses", "*");

	if (!empty($datas)) {

        echo '<div class="panel panel-default">';
        echo '<div class="panel-heading">';
        echo 'Edit Issue';
        echo '</div>';
        echo '<div class="panel-body">';

        foreach($datas as $data) { //fixme: there will be only one!
                echo '<form action="index.php?action=trackissues&id=' . $id . '" class="padded" method="post">';
                echo '<input type="hidden" name="action" value="trackissues">';
                echo '<input type="hidden" name="edit" value="update">';
                echo '<input type="hidden" name="id" value="' . $data["issue_id"] . '">';
                echo '<p><span>ID:</span><span class="right">' . $data["issue_id"] . '</span></p>';
                echo '<p><span>House:</span><span class="right">';
                echo '<select name="house">';

                foreach ($dataho as $dataitem) {
                        echo '<option value="' . $dataitem["id"] . '"';
                        if ($data["house_id"] == $dataitem["id"]) { echo 'selected'; }
                        echo '>' . $dataitem["name"] . '</option>';
                        }

                echo '</select></span></p>';
                echo '<p><span>Issue Type:</span><span class="right">';
                echo '<select name="issuetype">';

                foreach ($datait as $dataitem) {
                        echo '<option value="' . $dataitem["id"] . '"';
                        if ($data["typeid"] == $dataitem["id"]) { echo 'selected'; }
                        echo '>' . $dataitem["type"] . '</option>';
                        }

                echo '</select></span></p>';
                echo '<p>Issue:</p>';
		echo '<p><input name="issue" type="text" size="40" maxlength="128" value="' . $data["issue"] . '"></p>';
                echo '<p>Description:</p>';
                echo '<textarea cols="36" rows="8" name="description">' . $data["description"] . '</textarea><br><br>';
                echo '<input type="submit" name="Edit &raquo;" value="update" maxlength="1024">';
                echo '<a href="index.php?action=trackissues" class="button right">RESET</a><br>';
                echo '</form>';
        }

        echo '</div></div>'; // end body, end panel

	}
	else { 
		echo '<p>No Issues, enter new:</p>';
		newTrackIssue();
	}

}

function addIssueTracking() {
        global $database, $id;

        echo '<div class="panel panel-default">';
        echo '<div class="panel-heading">';
        echo 'Add Issue Tracking';
        echo '</div>';
        echo '<div class="panel-body">';

                echo '<form action="index.php?action=trackissues&id=' . $id .'" class="padded" method="post">';
                echo '<input type="hidden" name="action" value="trackissues">';
                echo '<input type="hidden" name="edit" value="addtracking">';
                echo '<input type="hidden" name="id" value="' . $id . '">';
                echo '<p>Tracking Info:</p>';
                echo '<textarea cols="36" rows="8" name="description">Enter Update Here</textarea><br><br>';
                echo '<input type="submit" name="Edit &raquo;" value="update" maxlength="1024">';
                echo '<a href="index.php?action=trackissues&id=' . $id . '" class="button right">RESET</a><br>';
                echo '</form>';

        echo '</div></div>'; // end body, end panel
}


/*
<form class="form-horizontal">
    <div class="form-group">
        <label for="inputEmail" class="control-label col-xs-2">Email</label>
        <div class="col-xs-10">
            <input type="email" class="form-control" id="inputEmail" placeholder="Email">
        </div>
    </div>
    <div class="form-group">
        <label for="inputPassword" class="control-label col-xs-2">Password</label>
        <div class="col-xs-10">
            <input type="password" class="form-control" id="inputPassword" placeholder="Password">
        </div>
    </div>
    <div class="form-group">
        <div class="col-xs-offset-2 col-xs-10">
            <div class="checkbox">
                <label><input type="checkbox"> Remember me</label>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-xs-offset-2 col-xs-10">
            <button type="submit" class="btn btn-primary">Login</button>
        </div>
    </div>
</form>
*/

function searchHouse() {
	global $database;

        $datas = $database->select("houses", array( "id", "name" ));

        echo '<form action="index.php" method="post">';
        echo '<input type="hidden" name="action" value="trackissues">';
        echo '<input type="hidden" name="edit" value="search">';
        echo '<input type="hidden" name="search" value="house">';
	echo '<p>';
        echo '<select name="searchissuetype">';
	echo '<option value="">By House</option>';
        foreach($datas as $data) {
          echo '<option value="' . $data["id"] . '">' . $data["name"] . '</option>';
          }
        echo '</select>';
	echo '</p>';
        echo '<p><input type="submit" name="search &raquo;" value="submit" maxlength="64"></p>';
        echo '</form>';
}

function searchIssue() {
	global $database;

        echo '<form action="index.php" method="post">';
        echo '<input type="hidden" name="action" value="trackissues">';
        echo '<input type="hidden" name="edit" value="search">';
        echo '<input type="hidden" name="search" value="issue">';
	echo '<p>';
        echo '<select name="searchissuetype">';
	echo '<option value="">By Issue</option>';
        // search issue dropdown
        $datas = $database->select("issuetypes", array( "id", "type" ));
        foreach($datas as $data) {
          echo '<option value="' . $data["id"] . '">' . $data["type"] . '</option>';
          }
        echo '</select>';
	echo '</p>';
        echo '<p><input type="submit" name="search &raquo;" value="submit" maxlength="64"></p>';
	echo '</form>';
}

function newTrackIssue () {
	global $database;
//	global $action;
//	global $edit;
//	global $id;

//  echo '<input type="hidden" name="action" value="trackissues">';
//  echo '<input type="hidden" name="edit" value="edit">';
//  echo '<input type="hidden" name="id" value="' . $data["issue_id"] . '">';

        echo '<div class="panel panel-default">';
        echo '<div class="panel-heading">';
        echo 'New Issue';
        echo '</div>';
        echo '<div class="panel-body">';

        echo '<form action="index.php" method="post" class="padded">';
        echo '<input type="hidden" name="action" value="trackissues">';
        echo '<input type="hidden" name="edit" value="new">';
        echo 'House:<br>';
        echo '<select name="id">';
                // house types dropdown
                $datas = $database->select("houses", array( "id", "name" ));
                foreach($datas as $data) {
                        echo '<option value="' . $data["id"] . '">' . $data["name"] . '</option>';
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
	global $database;
	global $page;
	global $search;
	global $searchissuetype;

if ($search == "none") {
	// select issues left join houses, left join issuetypes
	// LIMIT array(offset, rows)
	$datas=$database->select("issues",
		array("[>]houses" => array("house" => "id"),"[>]issuetypes" => array("issuetype" => "id")),
		array("issues.id(issue_id)","houses.name(house_name)","issuetypes.type(issue_type)","issues.issue(issue)","issues.date(date)"),
                array("LIMIT" => array(($page*5)-5,5))
		);

	echo '<div class="panel panel-default">';
	echo '<div class="panel-heading">';
	echo 'Issue List';
	echo '</div>';
	echo '<div class="panel-body">';

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

        // fetch count of all rows in issues
        $count = $database->count("issues");
                // optional: $where: array("column" => "value")

        $pages=$count/5;

        $min = 0;
        $max = $pages;
        //$start = $pages - 5;
        $start = 1;
        if ($start < 0) { $start = 1; }
        for ( ; $start <= $max ; $start++ ) {
                echo '&nbsp<a href="index.php?action=trackissues&page=' . $start . '">Page ' . $start . '</a>';
                }


	echo '</div></div>'; // end body, end cell
} // end search is none
if ($search == "house") {
        $datas=$database->select("issues",
                array("[>]houses" => array("house" => "id"),"[>]issuetypes" => array("issuetype" => "id")),
                array("issues.id(issue_id)","houses.name(house_name)","issuetypes.type(issue_type)","issues.issue(issue)","issues.date(date)"),
                array("houses.id" => $searchissuetype),
                array("LIMIT" => array(($page*5)-5,5))
                );

        $count=count($datas);
        $pages=$count/5;

        echo '<div class="panel panel-default">';
        echo '<div class="panel-heading">';
        echo 'Searched Issue List (by house)';
        echo '</div>';
        echo '<div class="panel-body">';
// DEBUG
//      echo '<p>' . $database->last_query() . '</p>';
//      echo '<p>issue type is ' . $searchissuetype . '</p>';
//      echo '<p>page is ' . $page . '</p>';
// END DEBUG

        echo '<table class="table"><thead><tr><th>House</th><th>Issue Type</th><th>Issue</th><th>Date</th><th></th></tr></thead>';
        echo '<tbody>';

        foreach ($datas as $data) {
                echo '<tr>';
                echo '<td>' . $data["house_name"] . '</td>';
                echo '<td>' . $data["issue_type"] . '</td>';
                echo '<td>' . $data["issue"] . '</td>';
                echo '<td>' . $data["date"] . '</td>';
                echo '<td><form action="index.php?edit=search&search=house&action=trackissues&searchissuetype=' . $searchissuetype . '" class="padded" method="post">';
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

$min = 0;
$max = $pages+1;
$start = $pages - 5;
if ($start < 0) { $start = 1; }
for ( ; $start <= $max ; $start++ ) {
        echo '&nbsp<a href="index.php?action=trackissues&page=' . $start . '">Page ' . $start . '</a>';
        }

        echo '</div></div>'; // end body, end cell
}

if ($search == "issue") {

        $datas=$database->select("issues",
                array("[>]houses" => array("house" => "id"),"[>]issuetypes" => array("issuetype" => "id")),
                array("issues.id(issue_id)","houses.name(house_name)","issuetypes.type(issue_type)","issues.issue(issue)","issues.date(date)"),
		array("issuetypes.id" => $searchissuetype),
                array("LIMIT" => array(($page*5)-5,5))
                );

        $count=count($datas);
        $pages=$count/5;

        echo '<div class="panel panel-default">';
        echo '<div class="panel-heading">';
        echo 'Searched Issue List (by Issue)';
        echo '</div>';
        echo '<div class="panel-body">';
// DEBUG
//	echo '<p>' . $database->last_query() . '</p>';
//	echo '<p>issue type is ' . $searchissuetype . '</p>';
//	echo '<p>page is ' . $page . '</p>';
// END DEBUG

        echo '<table class="table"><thead><tr><th>House</th><th>Issue Type</th><th>Issue</th><th>Date</th><th></th></tr></thead>';
        echo '<tbody>';

        foreach ($datas as $data) {
                echo '<tr>';
                echo '<td>' . $data["house_name"] . '</td>';
                echo '<td>' . $data["issue_type"] . '</td>';
                echo '<td>' . $data["issue"] . '</td>';
                echo '<td>' . $data["date"] . '</td>';
                echo '<td><form action="index.php?edit=search&search=issue&action=trackissues&searchissuetype=' . $searchissuetype . '" class="padded" method="post">';
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

$min = 0;
$max = $pages+1;
$start = $pages - 5;
if ($start < 0) { $start = 1; }
for ( ; $start <= $max ; $start++ ) {
        echo '&nbsp<a href="index.php?action=trackissues&page=' . $start . '">Page ' . $start . '</a>';
        }

        echo '</div></div>'; // end body, end cell
}

}

function showTrackIssue() {
        global $database, $id;

        // select issues left join issuetracking where issues.id == issuetracking.parent
        $datas=$database->select("issuetracking",
                array("[>]issues" => array("parent" => "id")),
                array("issuetracking.item(issue_item)","issuetracking.date(track_date)"),
		array("issues.id" => $id)
                );

        echo '<div class="panel panel-default">';
        echo '<div class="panel-heading">';
        echo 'Issue Tracking';
        echo '</div>';
        echo '<div class="panel-body">';

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

// begin html
echo '<div class="container-fluid">';
 echo '<div class="row">';

  echo '<div class="col-md-2">';

  //show search options
  echo '<div class="row-fluid">';
  echo '<p>Search:</p>';
  searchHouse();
  echo '<br>';
  searchIssue();
  echo '<br>';
  echo '<p><a class="btn btn-info" href="index.php?action=trackissues">Reset</a></p>';
  echo '<br>';
  echo '</div>'; //end row-fluid

  echo '</div>'; //end col

  echo '<div class="col-md-10">';

  echo '<div class="row-fluid">';

  if ($reentry == "0") {
    echo '<div class="col-md-4">';
    newTrackIssue();
    echo '</div>'; //end col
    echo '<div class="col-md-8">';
    showTrackIssueList();
    echo '</div>'; //end col
    }

  if ($reentry == "1") {
    if ($edit=="search") {
        echo '<div class="col-md-4">';
        newTrackIssue();
        echo '</div>'; //end col
        echo '<div class="col-md-8">';
        showTrackIssueList();
        echo '</div>'; //end col
        }

    if ($edit=="edit") {
        echo '<div class="col-md-4">';
        editTrackIssue();
        echo '</div>'; //end col
        echo '<div class="col-md-8">';
        addIssueTracking();
        echo '</div>'; //end col
        }
    }

    echo '</div>'; //end row

    echo '<div class="row-fluid">';
    echo '<div class="col-md-12">';
    showTrackIssue();
    echo '</div>'; //end col
    echo '</div>'; //end row

  echo '</div>'; //end second col
 echo '</div>'; //end row
echo '</div>'; //end container-fluid
