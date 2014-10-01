<?php

function checkForChild($parent, $child) {
  global $database;

  $count = $database->count("issuetypes", array("parent" => "$parent"));
  return $count;
  //if id is used as a parent, return number of rows

  // so if id = 1,

}

//needed by ...everything
$dataparent = $database->select("issuetypes", array( "id", "type", "parent" ));

function updateIssueType() {
  global $database, $id, $dataparent;

  //TODO: specify columns here
  $data = $database->get("issuetypes", array( "id", "type", "description", "parent"), array( "id[=]" => $id ));
  //$data = $database->get("issuetypes", "*", array( "id[=]" => $id ));

  //DEBUG
  //echo "last query was: " . $database->last_query();
  //DEBUG END

  echo '<div class="panel panel-default">';
  echo '<div class="panel-heading">';
  echo 'Update Issue Type "' . $data["type"] . '"';
  echo '</div>';
  echo '<div class="panel-body">';

  echo '<form action="index.php" method="post" class="padded">';
  echo '<input type="hidden" name="action" value="issues">';
  echo '<input type="hidden" name="edit" value="update">';
  echo '<input type="hidden" name="id" value="' . $data["id"] . '">';

  echo 'ID: ' . $data["id"] . '<br><br>';

  // parent list dropdown
  echo 'Parent:<br>';
  echo '<select name="parent">\n';
  echo '<option value="0">-- none --</option>';
  foreach($dataparent as $datap) {
    if ($data["id"] != $datap["id"]) {
      echo '<option value="' . $datap["id"] . '"';
      if ($data["parent"] == $datap["id"]) { echo "selected"; }
      echo '>' . $datap["type"] . '</option>\n';
    }
  }
  echo '</select><br><br>';

  echo 'Short Description:<br>';
  echo '<input name="issuetype" type="text" size="40" maxlength="128" value="' . $data["type"] . '">';
  echo '<br><br>'; 
  echo 'Long Description:<br>';
  echo '<textarea name="description" cols="40" rows="8">' . $data["description"] . '</textarea><br><br>';
  echo '<input class="btn btn-default" type="submit" name="Add &raquo;" value="Update" maxlength="1024">';
  echo '<a class="btn btn-primary pull-right" href="index.php?action=issues">Reset</a>';
  echo '</form>';  

  echo '</div></div>';

  echo '<div class="panel panel-default">';
  echo '<div class="panel-heading">';
  echo 'Children of Issue Type "' . $data["type"] . '"';
  echo '</div>';
  echo '<div class="panel-body">';

  echo '<table class="table table-striped">';
  echo '<thead><tr><th>ID</th><th>Issue Type</th><th>Description</th></tr></thead>';
  echo '<tbody>';

  foreach($dataparent as $datap) {
    if ($data["id"] == $datap["parent"]) { echo "<tr><td>" . $datap['id'] . "</td><td>" . $datap['type'] . "</td><td>" . $datap['description'] . "</td></tr>"; }
  } 

  echo '</tbody></table>';

  echo '</div></div>';

}

function newIssueType() {
  global $dataparent;

  echo '<div class="panel panel-default">';
  echo '  <div class="panel-heading">';
  echo 'New Issue Type';
  echo '  </div>';
  echo '<div class="panel-body">';

  echo '<form action="index.php" method="post" class="padded">';
  echo '<input type="hidden" name="action" value="issues">';
  echo '<input type="hidden" name="edit" value="new">';

  // parent list dropdown
  echo 'Parent:<br>';
  echo '<select name="parent">\n';
  echo '<option value="0">-- none --</option>';
  foreach($dataparent as $datap) {
    if ($data["id"] != $datap["id"]) {
      echo '<option value="' . $datap["id"] . '"';
      if ($data["id"] == $datap["id"]) { echo "selected"; }
      echo '>' . $datap["type"] . '</option>\n';
    }
  }
  echo '</select><br><br>';

  echo 'Issue Short Description:<br>';
  echo '<input name="issuetype" type="text" size="40" maxlength="128" >';
  echo '<br><br>';
  echo 'Issue Long Description:<br>';
  echo '<textarea name="description" cols="40" rows="8"></textarea><br><br>';
  echo '<input class="btn btn-default" type="submit" name="Add &raquo;" value="New" maxlength="1024">';
  echo '<a class="btn btn-primary pull-right" href="index.php?action=issues">Reset</a>';
  echo '</form>';

  echo '</div></div>';
}

function issueTypeList() {
  global $database;
  global $page;

  $limit = 5;
  $offset = ($page*5) - $limit;

  //DEBUG
  //echo "page is $page, limit is $limit, offset is $offset";
  //DEBUG END

  $datas = $database->select("issuetypes",
                       array("id", "type", "description", "parent"),
                       array("LIMIT" => array($offset,$limit)));

  //DEBUG
  //echo "datas is " . sizeof($datas) . " big";
  //print_r($datas);
  //DEBUG END

  echo '<div class="panel panel-default">';
  echo '<div class="panel-heading">';
  echo 'Issue Type List';
  echo '</div>';
  echo '<div class="panel-body">';

  echo '<table class="table table-striped">';
  echo '<thead><tr><th>ID</th><th>Issue Type</th><th>Description</th><th>Parent ID</th></tr></thead>';
  echo '<tbody>'; 

  foreach($datas as $data) {
    echo '<tr>';
    echo '<td>' . $data["id"] . '</td>';
    echo '<td>' . $data["type"] . '</td>';
    echo '<td>' . $data["description"] . '</td>';
    echo '<td>' . $data["parent"] . '</td>';
    echo '<td><form action="index.php?page=' . $page . '" class="padded" method="post">';
    echo '<input type="hidden" name="action" value="issues">';
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

/*********************
 * on edit, do stuff *
 *********************/

if ($edit == "new") {
  $database->insert("issuetypes",
    array("type" => "$issuetype","description" => "$description", "parent" => "$parent"));
}

//if ($edit == "edit") { $reentry = "1"; }

if ($edit == "update") {
  //DEBUG
  //echo "parent is $parent, desc is $description, type is $issuetype, id is $id";
  //DEBUG END

  $database->update("issuetypes",
    array("type" => "$issuetype", "description" => "$description","parent" => "$parent"),
    array( "id" => "$id" ));
}

/*****************
 * start of html *
 *****************/

echo '<div class="container-fluid">';
echo '<div class="row">';

echo '<div class="col-sm-4">';
if ($edit == "edit") { updateIssueType(); }
else { newIssueType(); }
echo '</div>';

echo '<div class="col-sm-8">';
issueTypeList();
echo '</div>';

echo '</div>';
echo '</div>';

?>
