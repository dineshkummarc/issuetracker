<?php

// dropdowns require these

//$datahouse = $database->select("houses", array( "id", "name" ));
//$dataissue = $database->select("issuetypes", array( "id", "type", "parent" ));
//$datastatus = $database->select("status", array( "id", "status" ));

//TODO: merge dropdowns into one, call by array, check by id
function statusDropDown($id = 0) {
  global $datastatus, $edit;

  foreach($datastatus as $data) {                                                                                                                                                                                                                                                 
    echo '<option value="' . $data["id"] . '"';                                                                                                                                                                                                                                   
    if (($edit == "edit") AND ($data["id"] == $id)) { echo "selected"; }                                                                                                                                                                                      
    echo '>' . $data["status"] . '</option>\n';                                                                                                                                                                                                                                   
  }
}

function houseDropDown($id = 0) {
  global $datahouse, $edit;

  foreach($datahouse as $data) {
    echo '<option value="' . $data["id"] . '"';
    if (($edit == "edit") AND ($data["id"] == $id)) { echo "selected"; }
    echo '>' . $data["name"] . '</option>\n';
  }
}

function issueDropDown($id = 0) {
  //$id is the id you want to check against (ie the parent)
  global $dataissue;
  $issuetree = buildTree($dataissue);
  printTreeDropDown($id, $issuetree);
}

function paginate($count) {
  global $action, $search, $id, $page, $edit;
  global $house, $issuetype, $status;

  if ($count > 5) {

    $pages=$count/5;
    if ((($count % 5) > 0) AND ($count > 5)) { $pages += 1; }
  
    $min = 0;
    $max = $pages;
    //$start = $page - 5;
    //$start = 1;
    //if ($start < 0) { $start = 1; }
    for ( $start = 1 ; $start <= $max ; $start++ ) {
  
      $url="";
      if ($action)    { $url  = "action=$action&"; }
      if ($search)    { $url .= "search=$search&"; }
      if ($id)        { $url .= "id=$id&"; }
      if ($page)      { $url .= "page=$start&"; }
      if ($edit)      { $url .= "edit=$edit&"; }
      if ($house)     { $url .= "house=$house&"; }
      if ($issuetype) { $url .= "issuetype=$issuetype&"; }
      if ($status)    { $url .= "status=$status"; }
  
      echo "<a class=\"btn btn-info\" href=\"index.php?$url\">$start</a>&nbsp";
    }
  }
}

function buildTree(array $data, $parent = 0) {
  $tree = array();
  foreach ($data as $d) {
    if ($d['parent'] == $parent) {
      $children = buildTree($data, $d['id']);
      // set a trivial key
      if (!empty($children)) {
        $d['_children'] = $children;
      }
      $tree[] = $d;
    }
  }
  return $tree;
}

function printTree($tree, $r = 0, $p = null) {
  foreach ($tree as $i => $t) {
    $dash = ($t['parent'] == 0) ? '' : str_repeat('--', $r) .' ';
    //printf("\t<option value='%d'>%s%s</option>\n", $t['id'], $dash, $t['type']);
    printf("%s%s<br>\n", $dash, $t['type']);
    if ($t['parent'] == $p) {
      // reset $r
      $r = 0;
    }
    if (isset($t['_children'])) {
      printTree($t['_children'], ++$r, $t['parent']);
    }
  }
}

function printTreeDropDown($id, $tree, $r = 0, $p = null) {
  global $action;

  foreach ($tree as $i => $t) {
    $dash = ($t['parent'] == 0) ? '' : str_repeat('--', $r) .' ';

    echo "<!-- id is $id, t.parent is " . $t['parent'] . "-->";

    echo "\t<option ";

//    if ($id) {
//      if (($action == "issues") AND ($id == $t['id'])) { echo "selected"; }
//      elseif (($action == "trackissues") AND ($id == $t['id'])) { echo "selected"; }
//    }

    if ($id) { if ($id == $t['id']) { echo "selected"; }}

    //printf("\t<option value='%d'>%s%s</option>\n", $t['id'], $dash, $t['type']);
    printf(" value='%d'>%s%s</option>\n", $t['id'], $dash, $t['type']);
    if ($t['parent'] == $p) {
      // reset $r
      $r = 0;
    }
    if (isset($t['_children'])) {
      printTreeDropDown($id, $t['_children'], ++$r, $t['parent']);
    }
  }
}

function checkForChild($id) {
  global $database;

  $count = $database->count("issuetypes", array("parent" => "$id"));
  return $count;
  //return number of rows where $id is parent. If greater than 0,
  //don't set $parent in calling function
}

?>
