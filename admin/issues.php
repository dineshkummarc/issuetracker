<?php

if (!$parent) { $parent = ""; }

function updateIssueType() {
  global $database, $id, $dataissue;
  $datatree=buildTree($dataissue);

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
  echo '<option value="">-- none --</option>';
  issueDropDown($data['parent']);
  echo '</select><br><br>';

  echo 'Issue:<br>';
  echo '<input name="issuetype" type="text" size="40" maxlength="128" value="' . $data["type"] . '">';
  echo '<br><br>'; 
  echo 'Description:<br>';
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

  foreach($dataissue as $datap) {
    if ($data["id"] == $datap["parent"]) { echo "<tr><td>" . $datap['id'] . "</td><td>" . $datap['type'] . "</td><td>" . $datap['description'] . "</td></tr>"; }
  } 

  echo '</tbody></table>';
  echo '</div></div>';
}

function newIssueType() {
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
  echo '<option value="">-- none --</option>';
  issueDropDown();
  echo '</select><br><br>';

  echo 'Issue:<br>';
  echo '<input name="issuetype" type="text" size="40" maxlength="128" >';
  echo '<br><br>';
  echo 'Issue Description:<br>';
  echo '<textarea name="description" cols="40" rows="8"></textarea><br><br>';
  echo '<input class="btn btn-default" type="submit" name="Add &raquo;" value="New" maxlength="1024">';
  echo '<a class="btn btn-primary pull-right" href="index.php?action=issues">Reset</a>';
  echo '</form>';

  echo '</div></div>';
}

function issueTypeList() {
  global $database;
  global $page;
  global $dataissue;

  $limit = 10;
  $offset = ($page*$limit) - $limit;

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
  echo '<thead><tr><th>ID</th><th>Issue Type</th><th>Description</th><th>Parent</th></tr></thead>';
  echo '<tbody>'; 

  foreach($datas as $data) {
    echo '<tr>';
    echo '<td>' . $data["id"] . '</td>';
    echo '<td>' . $data["type"] . '</td>';
    echo '<td>' . $data["description"] . '</td>';
    //changing ID to TYPE
    echo '<td>';
    foreach ($dataissue as $data2) {
      //DEBUG
      //echo "data2.type is " . $data2['type'];
      //DEBUG END

      if ($data['parent'] == $data2['id'] ) { echo $data2['type']; } 
    }
    echo '</td>';

    echo '<td><form action="index.php?page=' . $page . '" class="padded" method="post">';
    echo '<input type="hidden" name="action" value="issues">';
    echo '<input type="hidden" name="id" value="' . $data["id"] . '">';
    echo '<input type="hidden" name="parent" value="' . $data["parent"] . '">';
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
  //var_dump($database->error());
}

//if ($edit == "edit") { $reentry = "1"; }

if ($edit == "update") {
  //DEBUG
  //echo "parent is $parent, desc is $description, type is $issuetype, id is $id";
  //DEBUG END

  if ((checkForChild($id) < 1) XOR ($id == $parent)) {
    $database->update("issuetypes",
      array("type" => "$issuetype", "description" => "$description","parent" => "$parent"),
      array( "id" => "$id" ));
  }
  else {
    echo '<div class="alert alert-warning" role="alert">';
    echo "  <strong>Error:</strong> ID $id : recursive ID parent/child relationships are not allowed.";
    echo '</div>';
  }
}

/* grab globals (after DB access!) */
$dataissue = $database->select("issuetypes", array( "id", "type", "parent", "description" ));

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

$tree = buildTree($dataissue);
printTree($tree);

echo '</div>';
echo '</div>';
echo '</div>';

?>
