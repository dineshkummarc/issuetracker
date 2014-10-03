<?php

function paginate($count) {
  global $action, $search, $id, $page, $edit;

  if ($count > 5) {

    $pages=$count/5;
    if ((($count % 5) > 0) AND ($count > 5)) { $pages += 1; }
  
    $min = 0;
    $max = $pages;
    //$start = $page - 5;
    //$start = 1;
    //if ($start < 0) { $start = 1; }
    for ( $start = 1 ; $start <= $max ; $start++ ) {
  
      $url = "action=$action&";
      $url .= "search=$search&";
      $url .= "id=$id&";
  //  $url .= "edit=$edit&";
      $url .= "page=$start";
  
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

function printTreeDropDown($tree, $r = 0, $p = null) {
  global $id;

  foreach ($tree as $i => $t) {
    $dash = ($t['parent'] == 0) ? '' : str_repeat('--', $r) .' ';
    echo "\t<option ";
    if ($id == $t['id']) { echo "selected"; }
//    printf("\t<option value='%d'>%s%s</option>\n", $t['id'], $dash, $t['type']);
    printf(" value='%d'>%s%s</option>\n", $t['id'], $dash, $t['type']);
    if ($t['parent'] == $p) {
      // reset $r
      $r = 0;
    }
    if (isset($t['_children'])) {
      printTreeDropDown($t['_children'], ++$r, $t['parent']);
    }
  }
}

?>

