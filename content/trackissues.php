s/Iss<?php

//setup globals
//if (!$action) { $action = "trackissues"; }
//if (!$id) { $id = 0; }

function showIssueTracking() {
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
    echo '<td>' . nl2br($data["issue_item"]) . '</td>';
    echo '</tr>';
  }

  echo '</tbody>';
  echo '</table>';

  echo '</div></div>'; // end body, end cell
}

function editIssue() {
  global $database;
  global $id;
  //global $edit, $status, $search, $action;
  global $edit, $action;
  global $datahouse, $dataissue, $datastatus;
  //global $house, $issue, $status

  //if edit is edit, then id is issue.id

  if ($edit == "edit") {
    $datatrack=$database->get("issues",
      array("issues.house(house_id)",
            "issues.issuetype(issuetype_id)",
            "issues.id(issue_id)",
            "issues.issue(issue)",
            "issues.date(date)",
            "issues.description(description)",
            "issues.status(status_id)"),
      array("issues.id" => "$id")
      );

    //DEBUG
    //echo $database->last_query();
    //print_r(array_values($datatrack));
    //echo 'datatrack.house_id is ' . $datatrack["house_id"];
    //echo $datatrack;
    //echo 'id is ' . $id;
    //echo "sizeof is " . sizeof($datatrack);
    //DEBUG END

  }
  else { $datatrack = array("house_id" => "", "issuetype_id" => "", "issue_id" => "", "issue" => "", "date" => "", "description" => "", "status_id" => ""); }

  echo '<div class="panel panel-default">';
  echo '<div class="panel-heading">';

  if ($edit == "edit") { echo 'Edit Issue'; }
  else { echo 'New Issue'; }

  echo '</div>';
  echo '<div class="panel-body">';

  echo '<form action="index.php" method="post">';
  echo '<input type="hidden" name="action" value="trackissues">';
  if ($edit == "edit") {
    echo '<input type="hidden" name="edit" value="update">';
    echo '<input type="hidden" name="id" value="' . $id . '">';
  }
  else { echo '<input type="hidden" name="edit" value="new">'; }

  // house list dropdown
  echo 'House:<br>';
  echo '<select name="house">\n';
  echo '<option value=""> -- House -- </option>';
  houseDropDown($datatrack['house_id']);
  echo '</select><br><br>';

  // issue type dropdown
  echo 'Issue Type:<br>';
  echo '<select name="issuetype"><br>';
  echo '<option value=""> -- Issue Type -- </option>';
  issueDropDown($datatrack['issuetype_id']);
  echo '</select><br><br>';

  //DEBUG
  //echo "<p>datatrack.issuetype_id was " . $datatrack['issuetype_id'] . "</p>";
  //DEBUG END

  // status type dropdown
  echo 'Status Type:<br>';
  echo '<select name="status"><br>';
  echo '<option value=""> -- Status -- </option>';
  statusDropDown($datatrack['status_id']);
  echo '</select><br><br>';

  //issue - short desc
  echo 'Short Description:<br>';
  echo '<input name="issue" type="text" size="40" maxlength="128"';
  if ($edit == "edit") { echo 'value="' . $datatrack["issue"] . '"'; }
  echo '">';
  echo '<br><br>';

  //description
  echo 'Issue Details:<br>';
  echo '<textarea name="description" cols="36" rows="8">';
  if ($edit == "edit") { echo $datatrack["description"]; }
  echo '</textarea><br><br>';
  echo '<input class="btn btn-default" type="submit" name="Add &raquo;" value="submit" maxlength="1024">';
  echo '<a class="btn btn-primary pull-right" href="index.php?action=trackissues" class="button right">Reset</a>';
  echo '</form>';

  echo '</div></div>';
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
  echo '<input class="btn btn-default" type="submit" name="Edit &raquo;" value="Edit &raquo;" maxlength="1024">';
  echo '<a href="index.php?action=trackissues&id=' . $id . '" class="btn btn-primary pull-right">Reset</a><br>';
  echo '</form>';

  echo '</div></div>'; // end body, end panel
}

function search() {
  //global $datahouse, $dataissue, $datastatus;

  echo '<form action="index.php" method="post">';
  echo '<input type="hidden" name="action" value="trackissues">';
  echo '<input type="hidden" name="edit" value="search">';
  echo '<input type="hidden" name="search" value="multi">';

  //house
  echo '<p>';
  echo '<select name="house">';
  echo '<option value="">-- By House --</option>';
  houseDropDown();
  echo '</select>';
  echo '</p>';

  //issue
  echo '<p>';
  echo '<select name="issuetype">';
  echo '<option value="">-- By Issue Type --</option>';
  issueDropDown();
  echo '</select>';
  echo '</p>';

  //status
  echo '<p>';
  echo '<select name="status">';
  echo '<option value="">-- By Status --</option>';
  statusDropDown();
  echo '</select>';
  echo '</p>';

  echo '<p>';
  echo '<input class="btn btn-default pull-left" type="submit" name="search &raquo;" value="search &raquo;" maxlength="64">';
  echo '</p>';

  echo '</form>';
}

function showTrackIssueList() {
  global $database;
  global $id;
  global $page;
  global $search;
  global $house, $issuetype, $status;

  $limit = 10;
  $offset = ($page*$limit) - $limit;

// this doesn't work, not even with %
//  if (!$house) { $house = '*'; }
//  if (!$issue) { $issue = '*'; }
//  if (!$status) { $status = '*'; }

$searchArray = array();

if ($house != "") { $searchArray["issues.house"] = "$house"; }
else { $searchArray["issues.house[!]"] = null; }

if ($issuetype != "") { $searchArray["issues.issuetype"] = "$issuetype"; }
else { $searchArray["issues.issue[!]"] = null; }

if ($status != "") { $searchArray["issues.status"] = "$status"; }
else { $searchArray["issues.status[!]"] = null; }

/* searchArray lunacy

if ($house != "") { add to array "issues.house" => "$house" }
else { add to array "issues.house[!]" => null }

if ($issue != "") { add to array "issues.issue" => "$issue" }
else { add to array "issues.issue[!]" => null }

if ($status != "") { add to array "issues.status" => "$status" }
else { add to array "issues.status[!]" => null }

*/

if ($search == "multi") {
  // select issues left join houses, left join issuetypes, right join status
  // LIMIT array(offset, rows)
  //$count=$database->count("issues",array("AND" => array("OR" => array("issues.house" => "$house","issues.issuetype" => "$issuetype","issues.status" => "$status"))));
  $count=$database->count("issues",array("AND" => $searchArray));

  $datas=$database->select("issues",
    array("[>]houses" => array("house" => "id"),"[>]issuetypes" => array("issuetype" => "id"),"[>]status" => array("status" => "id")),
    array("issues.id(issue_id)","houses.name(house_name)","issuetypes.type(issue_type)","issues.issue(issue)","issues.date(date)","houses.id(house_id)","status.status(status)","issuetypes.parent(issue_parent)"),
    array(
//          "AND" => array("OR" => array("issues.house" => "$house","issues.issuetype" => "$issuetype","issues.status" => "$status")),
          "AND" => $searchArray,
          "LIMIT" => array($offset,$limit),
         )
    );
} 
else {
  // select issues left join houses, left join issuetypes, right join status
  // LIMIT array(offset, rows)
  // note: LIMIT is part of WHERE
  $count=$database->count("issues");                                                                                                                                                                                                                                                                
  $datas=$database->select("issues",
    array("[>]houses" => array("house" => "id"),"[>]issuetypes" => array("issuetype" => "id"),"[>]status" => array("status" => "id")),
    array("issues.id(issue_id)","houses.name(house_name)","issuetypes.type(issue_type)","issues.issue(issue)","issues.date(date)","houses.id(house_id)","status.status(status)","issuetypes.parent(issue_parent)"),
    array("LIMIT" => array($offset,$limit))
    );
}

  echo '<div class="panel panel-default">';
  echo '<div class="panel-heading">';
  echo "Issue List";
  if ($search == "multi") { echo " Search : House ID is \"$house\", Issuetype ID is \"$issuetype\", Status ID is \"$status\""; }
  echo '</div>';
  echo '<div class="panel-body">';

  // DEBUG
  //echo '<p>' . $database->last_query() . '</p>';
  //echo '<p>issuetype is ' . $issuetype . '</p>';
  //echo '<p>offset is ' . $offset . '</p>';
  //echo '<p>limit is ' . $limit . '</p>';
  //echo '<p>page is ' . $page . '</p>';
  //echo '<p>search is ' . $search . '</p>';
  //echo '<p>house is ' . $house . '</p>';
  //echo '<p>issue is ' . $issue . '</p>';
  //echo '<p>status is ' . $status . '</p>';
  //echo "array is " . print_r($datas);
  // END DEBUG

  echo '<table class="table table-striped"><thead><tr><th>ID</th><th>House</th><th>Issue Type</th><th>Status</th><th>Issue</th><th>Date</th><th></th></tr></thead>';
  echo '<tbody>';

  foreach ($datas as $data) {
    // this should all be in the POST !!
    // except for maybe $page
    $url  = "action=$action&"; //should always be action=trackissues
    $url .= "search=$search&";
    $url .= "id=$id&";
    $url .= "edit=$edit&"; //should always be edit=search
    $url .= "page=$page";
    
    echo '<tr>';
    echo '<td>' . $data["issue_id"] . '</td>';
    echo '<td>' . $data["house_name"] . '</td>';
    echo '<td>' . $data["issue_type"] . '</td>';
    echo '<td>' . $data["status"] . '</td>';
    echo '<td>' . $data["issue"] . '</td>';
    echo '<td>' . $data["date"] . '</td>';
    echo "<td><form action=\"index.php?$url\" method=\"post\">";
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

   //DEBUG
   //echo "<p>search is $search</p>";
   //echo "<p>parent is $parent</p>";
   //echo "<p>data.issue_parent is " . $data["issue_parent"] . "</p>";
   //DEBUG END

   paginate($count);
}

if ($edit == "new") {
  $last_id = $database->insert("issues", array(
             "house" => "$house",
             "issue" => "$issue",
             "issuetype" => "$issuetype",
             "status" => "$status",
             "description" => "$description"));

  //DEBUG
  //echo "<p>status is $status</p>";
  //echo "<p>issuetype is $issuetype</p>";
  //echo "<p>house is $house</p>";
  //DEBUG END
}

/***************************
 * post to DB if necessary *
 ***************************/

if ($edit == "addtracking") { $database->insert("issuetracking", array( "parent" => "$id", "item" => "$description")); }

if ($edit == "update") {
  $database->update("issues", array(
      "house" => "$house",
      "issuetype" => "$issuetype",
      "issue" => "$issue",
      "status" => "$status",
      "description" => "$description"),
    array( "id" => "$id" ));

  //DEBUG
  //echo "<p>status is $status</p>";
  //DEBUG END
}

/******************************
 * fetch from DB if necessary *
 ******************************/

// these are required by the dropdowns
//$datahouse = $database->select("houses", array( "id", "name" ));
$datahouse = $database->select("houses", array( "id", "name" ),array("ORDER" => "name"));
$dataissue = $database->select("issuetypes", array( "id", "type", "parent" ));
$datastatus = $database->select("status", array( "id", "status" ));

/**************
 * begin html *
 **************/

echo '<div class="container-fluid">';
 echo '<div class="row">';

  echo '<div class="col-md-2">';

  //multisearch
  echo '<div class="row-fluid">';
  echo '<p>Search:</p>';
  search();
  echo '<p><a class="btn btn-primary pull-right" href="index.php?action=trackissues">Reset</a></p>';
  echo '</div>'; //end row-fluid

  //DEBUG
  //echo "<p>action is $action</p>";
  //echo "<p>edit is $edit</p>";
  //echo "<p>id is $id</p>";
  //echo "<p>status is $status</p>";
  //echo "<p>search is $search</p>";
  //DEBUG END

  echo '</div>'; //end col
  echo '<div class="col-md-10">';
  echo '<div class="row-fluid">';

  if ($edit=="search") {
    echo '<div class="col-md-4">';
    editIssue();
    echo '</div>'; //end col
    echo '<div class="col-md-8">';
    showTrackIssueList();
    echo '</div>'; //end col
  }
  elseif (($edit=="addtracking") OR ($edit=="edit")) {
    echo '<div class="col-md-4">';
    editIssue();
    echo '</div>'; //end col
    echo '<div class="col-md-8">';

    echo '<div class="row-fluid">';
    echo '<div class="col-md-12">';
    addIssueTracking();
    echo '</div>'; //end col(12)
    echo '</div>'; //end row

    echo '<div class="row-fluid">';
    echo '<div class="col-md-12">';
    showIssueTracking();
    echo '</div>'; //end col
    echo '</div>'; //end row

    echo '</div>'; //end col(8)
  }
  else {
    echo '<div class="col-md-4">';
    editIssue();
    echo '</div>'; //end col
    echo '<div class="col-md-8">';
    showTrackIssueList();
    echo '</div>'; //end col
    }

  echo '</div>'; //end row

  echo '</div>'; //end second col
 echo '</div>'; //end row
echo '</div>'; //end container-fluid

// DEBUG
echo '<div class="container">'; //end container-fluid
  //echo '<p>' . $database->last_query() . '</p>';
  //echo '<p>issue type is ' . $searchissuetype . '</p>';
  //echo '<p>offset is ' . $offset . '</p>';
  //echo '<p>limit is ' . $limit . '</p>';
  //echo '<p>page is ' . $page . '</p>';
  //echo '<p>search is ' . $search . '</p>';
  //echo '<p>house is ' . $house . '</p>';
  //echo '<p>id is ' . $id . '</p>';
  //echo '<p>issue is ' . $issue . '</p>';
  //echo '<p>status is ' . $status . '</p>';
  //echo '<p>action is ' . $action . '</p>';
  //echo '<p>parent is ' . $parent . '</p>';
  //echo "array is " . print_r($datas);
echo '</div>'; //end container-fluid
// DEBUG END
