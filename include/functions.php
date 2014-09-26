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

?>

