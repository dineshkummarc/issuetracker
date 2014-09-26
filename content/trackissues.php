<?php

// this is needed in searchHouse, searchIssue and newIssue
$datahouse = $database->select("houses", array( "id", "name" ));
$dataissue = $database->select("issuetypes", array( "id", "type" ));
$datastatus = $database->select("status", array( "id", "status" ));

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

// calling these two once, just before html
//        $datahouse = $database->select("houses", array( "id", "name" ));
//        $dataissue = $database->select("issuetypes", array( "id", "type" ));

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
                echo '<p><span>ID:</span><span class="pull-right">' . $data["issue_id"] . '</span></p>';
                echo '<p><span>House:</span><span class="pull-right">';
                echo '<select name="house">';

                foreach ($datahouse as $dataitem) {
                        echo '<option value="' . $dataitem["id"] . '"';
                        if ($data["house_id"] == $dataitem["id"]) { echo 'selected'; }
                        echo '>' . $dataitem["name"] . '</option>';
                        }

                echo '</select></span></p>';
                echo '<p><span>Issue Type:</span><span class="pull-right">';
                echo '<select name="issuetype">';

                foreach ($dataissue as $dataitem) {
                        echo '<option value="' . $dataitem["id"] . '"';
                        if ($data["typeid"] == $dataitem["id"]) { echo 'selected'; }
                        echo '>' . $dataitem["type"] . '</option>';
                        }

                echo '</select></span></p>';
                echo '<p>Issue:</p>';
		echo '<p><input name="issue" type="text" size="40" maxlength="128" value="' . $data["issue"] . '"></p>';
                echo '<p>Description:</p>';
                echo '<textarea cols="36" rows="8" name="description">' . $data["description"] . '</textarea><br><br>';
                echo '<input class="btn btn-default" type="submit" name="Edit &raquo;" value="update" maxlength="1024">';
                echo '<a href="index.php?action=trackissues" class="btn btn-primary pull-right">Reset</a><br>';
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
                echo '<input class="btn btn-default" type="submit" name="Edit &raquo;" value="update" maxlength="1024">';
                echo '<a href="index.php?action=trackissues&id=' . $id . '" class="btn btn-primary pull-right">Reset</a><br>';
                echo '</form>';

        echo '</div></div>'; // end body, end panel
}


// $dataissue populated at top
function searchHouse() {
	global $database;
	global $datahouse;

	echo '<p>';
        echo '<form action="index.php" method="post">';
        echo '<input type="hidden" name="action" value="trackissues">';
        echo '<input type="hidden" name="edit" value="search">';
        echo '<input type="hidden" name="search" value="house">';
        echo '<select name="id">';
	echo '<option value="">-- By House --</option>';
        foreach($datahouse as $data) { echo '<option value="' . $data["id"] . '">' . $data["name"] . '</option>'; }
        echo '</select>';
        echo '<input class="btn btn-default pull-right" type="submit" name="search &raquo;" value="submit" maxlength="64">';
        echo '</form>';
	echo '</p>';
}

// $dataissue populated at top
function searchIssue() {
	global $database;
	global $dataissue;

	echo '<p>';
        echo '<form action="index.php" method="post">';
        echo '<input type="hidden" name="action" value="trackissues">';
        echo '<input type="hidden" name="edit" value="search">';
        echo '<input type="hidden" name="search" value="issue">';
        echo '<select name="id">';
	echo '<option value="">-- By Issue --</option>';
        foreach($dataissue as $data) { echo '<option value="' . $data["id"] . '">' . $data["type"] . '</option>'; }
        echo '</select>';
        echo '<input class="btn btn-default pull-right" type="submit" name="search &raquo;" value="submit" maxlength="64">';
	echo '</form>';
	echo '</p>';
}

// $dataissue populated at top
function searchStatus() {
        global $datastatus;
        global $dataissue;

	echo '<p>';
        echo '<form action="index.php" method="post">';
        echo '<input type="hidden" name="action" value="trackissues">';
        echo '<input type="hidden" name="edit" value="search">';
        echo '<input type="hidden" name="search" value="status">';
        echo '<select name="id">';
        echo '<option value="">-- By Status --</option>';
        foreach($datastatus as $data) { echo '<option value="' . $data["id"] . '">' . $data["status"] . '</option>'; }
        echo '</select>';
        echo '<input class="btn btn-default pull-right" type="submit" name="search &raquo;" value="submit" maxlength="64">';
        echo '</form>';
	echo '</p>';
}


function newTrackIssue () {
	global $database;
//	global $action;
//	global $edit;
	global $id;
	global $search;

        $datahouse = $database->select("houses", array( "id", "name" ));
        $dataissue = $database->select("issuetypes", array( "id", "type" ));

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
		if ($search == "house") {
                    foreach($datahouse as $data) {
                        if ($data["id"] == $id) { echo '<option selected value="' . $data["id"] . '">' . $data["name"] . '</option>'; }
			else { echo '<option value="' . $data["id"] . '">' . $data["name"] . '</option>'; }
			}
               	}
		else {
		    echo '<option selected value="">-- select house --</option>';
		    foreach($datahouse as $data) { echo '<option value="' . $data["id"] . '">' . $data["name"] . '</option>'; }
		}

        echo '</select><br><br>';
        echo 'Issue Type:<br>';
        echo '<select name="issuetype"><br>';
	echo '<option selected value="">-- select issue type --</option>';
                // issue type dropdown
                foreach($dataissue as $data) { echo '<option value="' . $data["id"] . '">' . $data["type"] . '</option>'; }
        echo '</select><br><br>';
        echo 'Short Description:<br>';
        echo '<input name="issue" type="text" size="40" maxlength="128" >';
        echo '<br><br>';
        echo 'Issue Details:<br>';
        echo '<textarea name="description" cols="36" rows="8"></textarea><br><br>';
        echo '<input class="btn btn-default" type="submit" name="Add &raquo;" value="submit" maxlength="1024">';
        echo '<a href="index.php?action=trackissues" class="btn btn-primary pull-right">Reset</a>';
        echo '</form>';

        echo '</div></div>';
}

function showTrackIssueList() {
	global $database;
//	global $searchissuetype;
	global $page;
	global $search;
	global $edit;
	global $id;
	global $action;

	$limit = 5;
	$offset = ($page*5) - $limit;

if ($search == "none") {
	// select issues left join houses, left join issuetypes
	// LIMIT array(offset, rows)
        $count=$database->count("issues");                                                                                                                                                                                                                                                                
	$datas=$database->select("issues",
		array("[>]houses" => array("house" => "id"),"[>]issuetypes" => array("issuetype" => "id")),
		array("issues.id(issue_id)","houses.name(house_name)","issuetypes.type(issue_type)","issues.issue(issue)","issues.date(date)","houses.id(house_id)"),
                array("LIMIT" => array($offset,$limit))
		);
	}

if ($search == "house") {
        $count=$database->count("issues",
                array("house" => $id)
                );

        $datas=$database->select("issues",
                array("[>]houses" => array("house" => "id"),"[>]issuetypes" => array("issuetype" => "id")),
                array("issues.id(issue_id)","houses.name(house_name)","issuetypes.type(issue_type)","issues.issue(issue)","issues.date(date)","houses.id(house_id)"),
                array("houses.id" => $id,"LIMIT" => array($offset,$limit))
                );
	}

if ($search == "issue") {

	$count=$database->count("issues",
                array("issuetype" => $id)
                );

        $datas=$database->select("issues",
                array("[>]houses" => array("house" => "id"),"[>]issuetypes" => array("issuetype" => "id")),
                array("issues.id(issue_id)","houses.name(house_name)","issuetypes.type(issue_type)","issues.issue(issue)","issues.date(date)","houses.id(house_id)"),
                array("issuetypes.id" => $id,"LIMIT" => array($offset,$limit))
                );

	}

if ($search == "status") {

        $count=$database->count("issues",
                array("issuetype" => $id)
                );

        $datas=$database->select("issues",
                array("[>]houses" => array("house" => "id"),"[>]issuetypes" => array("issuetype" => "id")),
                array("issues.id(issue_id)","houses.name(house_name)","issuetypes.type(issue_type)","issues.issue(issue)","issues.date(date)","houses.id(house_id)"),
                array("issuetypes.status" => $id,"LIMIT" => array($offset,$limit))
                );
  
        }


        echo '<div class="panel panel-default">';
        echo '<div class="panel-heading">';
        echo "Issue List (search by $search)";
        echo '</div>';
        echo '<div class="panel-body">';

// DEBUG
//	echo '<p>' . $database->last_query() . '</p>';
//	echo '<p>issue type is ' . $searchissuetype . '</p>';
//	echo '<p>offset is ' . $offset . '</p>';
//	echo '<p>limit is ' . $limit . '</p>';
//	echo '<p>page is ' . $page . '</p>';
//	echo '<p>search is ' . $search . '</p>';
// END DEBUG

        echo '<table class="table table-striped"><thead><tr><th>House</th><th>Issue Type</th><th>Issue</th><th>Date</th><th></th></tr></thead>';
        echo '<tbody>';

        foreach ($datas as $data) {

// this should all be in the POST !!
// except for maybe $page
    $url  = "action=$action&";
    $url .= "search=$search&";
//    $url .= "searchissuetype=$searchissuetype&";
    $url .= "id=$id&";
    $url .= "edit=$edit&"; //should always be edit=search
    $url .= "page=$page";

//    echo "<a href=\"index.php?$url\">Page $start</a>";

                echo '<tr>';
                echo '<td>' . $data["house_name"] . '</td>';
                echo '<td>' . $data["issue_type"] . '</td>';
                echo '<td>' . $data["issue"] . '</td>';
                echo '<td>' . $data["date"] . '</td>';
                echo "<td><form action=\"index.php?$url\" class=\"padded\" method=\"post\">";
                echo '<input type="hidden" name="action" value="trackissues">';
                echo '<input type="hidden" name="edit" value="edit">';
                echo '<input type="hidden" name="id" value="' . $data["issue_id"] . '">';
                echo '<button class="btn btn-default" type="submit" name="edit" value="edit">Edit</button>';
                echo '</form>';
                echo '</td>';
                echo '</tr>';
        }
                         
        echo '</tbody>';
        echo '</table>';

paginate($count);

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
  searchStatus();
  echo '<br>';
  echo '<p><a class="btn btn-primary" href="index.php?action=trackissues">Reset</a></p>';
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

    if ($edit=="addtracking") {
        echo '<div class="col-md-4">';
        editTrackIssue();
        echo '</div>'; //end col
        echo '<div class="col-md-8">';
        addIssueTracking();
        echo '</div>'; //end col
        }
    }

    echo '</div>'; //end row

  if ($reentry == "1") {
      if ($edit != "search") {
      echo '<div class="row-fluid">';
      echo '<div class="col-md-12">';
      showTrackIssue();
      echo '</div>'; //end col
      echo '</div>'; //end row
      }
    }

  echo '</div>'; //end second col
 echo '</div>'; //end row
echo '</div>'; //end container-fluid
