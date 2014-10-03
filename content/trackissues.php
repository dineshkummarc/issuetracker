<?php

// this is needed in searchHouse, searchIssue and newIssue
$datahouse = $database->select("houses", array( "id", "name" ));
$dataissue = $database->select("issuetypes", array( "id", "type", "parent" ));
$datastatus = $database->select("status", array( "id", "status" ));

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
    echo '<td>' . $data["issue_item"] . '</td>';
    echo '</tr>';
  }

  echo '</tbody>';
  echo '</table>';

  echo '</div></div>'; // end body, end cell
}

function editIssue () {
  global $database;
  global $id, $edit, $status, $search, $action;
  global $datahouse, $dataissue, $datastatus;

  if (!$id) { $id = 0; }

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

    //echo $database->last_query();
    //print_r(array_values($datatrack));
    //echo 'datatrack.house_id is ' . $datatrack["house_id"];
    //echo $datatrack;
    //echo 'id is ' . $id;
    //echo "sizeof is " . sizeof($datatrack);

  }

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
  foreach($datahouse as $data) {
    echo '<option value="' . $data["id"] . '"';
    if (($edit == "edit") AND ($data["id"] == $datatrack["house_id"])) { echo "selected"; }
    echo '>' . $data["name"] . '</option>\n';
  }
  echo '</select><br><br>';

  // issue type dropdown
  echo 'Issue Type:<br>';
  echo '<select name="issuetype"><br>';
  foreach($dataissue as $data) {
    echo '<option value="' . $data["id"] . '"';
    if (($edit == "edit") AND ($data["id"] == $datatrack["issuetype_id"])) { echo "selected"; }
    echo '>' . $data["type"] . '</option>\n';
  }
  echo '</select><br><br>';

  // status type dropdown
  echo 'Status Type:<br>';
  echo '<select name="status"><br>';
  foreach($datastatus as $data) {
    echo '<option value="' . $data["id"] . '"';
    if (($edit == "edit") AND ($data["id"] == $datatrack["status_id"])) { echo "selected"; }
    echo '>' . $data["status"] . '</option>\n';
  }
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
                echo '<input class="btn btn-default" type="submit" name="Edit &raquo;" value="update" maxlength="1024">';
                echo '<a href="index.php?action=trackissues&id=' . $id . '" class="btn btn-primary pull-right">Reset</a><br>';
                echo '</form>';

        echo '</div></div>'; // end body, end panel
}

function searchHouse() {
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

function searchIssue() {
  global $dataissue;
  $issuetree = buildTree($dataissue);

  echo '<p>';
        echo '<form action="index.php" method="post">';
        echo '<input type="hidden" name="action" value="trackissues">';
        echo '<input type="hidden" name="edit" value="search">';
        echo '<input type="hidden" name="search" value="issue">';
        echo '<select name="id">';
        echo '<option value="">-- By Issue --</option>';
//        foreach($dataissue as $data) { echo '<option value="' . $data["id"] . '">' . $data["type"] . '</option>'; }
        printTreeDropDown($issuetree);
        echo '</select>';
        echo '<input class="btn btn-default pull-right" type="submit" name="search &raquo;" value="submit" maxlength="64">';
  echo '</form>';
  echo '</p>';
}

function searchStatus() {
        global $datastatus;

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

function showTrackIssueList() {
  global $database;
  global $page;
  global $search;
  global $edit;
  global $id;
  global $action;

  $limit = 5;
  $offset = ($page*5) - $limit;

if ($search == "none") {
  // select issues left join houses, left join issuetypes, right join status
  // LIMIT array(offset, rows)
  $count=$database->count("issues");                                                                                                                                                                                                                                                                
  $datas=$database->select("issues",
    array("[>]houses" => array("house" => "id"),"[>]issuetypes" => array("issuetype" => "id"),"[>]status" => array("status" => "id")),
    array("issues.id(issue_id)","houses.name(house_name)","issuetypes.type(issue_type)","issues.issue(issue)","issues.date(date)","houses.id(house_id)","status.status(status)"),
    array("LIMIT" => array($offset,$limit))
    );
}

if ($search == "house") {
  $count=$database->count("issues", array("house" => $id));

  $datas=$database->select("issues",
    array("[>]houses" => array("house" => "id"),"[>]issuetypes" => array("issuetype" => "id"),"[>]status" => array("status" => "id")),
    array("issues.id(issue_id)","houses.name(house_name)","issuetypes.type(issue_type)","issues.issue(issue)","issues.date(date)","houses.id(house_id)","status.status(status)"),
    array("houses.id" => $id,"LIMIT" => array($offset,$limit))
    );
}

if ($search == "issue") {
  $count=$database->count("issues", array("issuetype" => $id));

  $datas=$database->select("issues",
    array("[>]houses" => array("house" => "id"),"[>]issuetypes" => array("issuetype" => "id"),"[>]status" => array("status" => "id")),
    array("issues.id(issue_id)","houses.name(house_name)","issuetypes.type(issue_type)","issues.issue(issue)","issues.date(date)","houses.id(house_id)","status.status(status)"),
    array("issuetypes.id" => $id,"LIMIT" => array($offset,$limit))
    );
}

if ($search == "status") {
  $count=$database->count("issues", array("status" => $id));

  $datas=$database->select("issues",
    array("[>]houses" => array("house" => "id"),"[>]issuetypes" => array("issuetype" => "id"),"[>]status" => array("status" => "id")),
    array("issues.id(issue_id)","houses.name(house_name)","issuetypes.type(issue_type)","issues.issue(issue)","issues.date(date)","houses.id(house_id)","status.status(status)"),
    array("issues.status" => $id,"LIMIT" => array($offset,$limit))
    );
}

  echo '<div class="panel panel-default">';
  echo '<div class="panel-heading">';
  echo "Issue List (search by $search)";
  echo '</div>';
  echo '<div class="panel-body">';

  // DEBUG
  //echo '<p>' . $database->last_query() . '</p>';
  //echo '<p>issue type is ' . $searchissuetype . '</p>';
  //echo '<p>offset is ' . $offset . '</p>';
  //echo '<p>limit is ' . $limit . '</p>';
  //echo '<p>page is ' . $page . '</p>';
  //echo '<p>search is ' . $search . '</p>';
  // END DEBUG

  echo '<table class="table table-striped"><thead><tr><th>ID</th><th>House</th><th>Issue Type</th><th>Status</th><th>Issue</th><th>Date</th><th></th></tr></thead>';
  echo '<tbody>';

  foreach ($datas as $data) {
    // this should all be in the POST !!
    // except for maybe $page
    $url  = "action=$action&";
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

if ($edit == "new") {
  $last_id = $database->insert("issues", array(
             "house" => "$id",
             "issue" => "$issue",
             "issuetype" => "$issuetype",
             "status" => "$status",
             "description" => "$description"));

  //DEBUG
  //echo "<p>status is $status</p>";
  //DEBUG END
}

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
