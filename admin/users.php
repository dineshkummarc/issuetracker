<?php

function newUsers() {
  global $database, $id, $edit;

  if ($edit == "edit") {
    $data=$database->get("users",array("id", "username", "name", "admin", "superuser", "user", "active"),array("id[=]" => "$id"));
  }
  else { $data = array("id" => "", "username" => "", "name" => "", "admin" => "", "superuser" => "", "user" => "", "active" => ""); }

  echo '  <div class="panel panel-default">';
  echo '    <div class="panel-heading">';
    if ($edit == "edit") { echo 'Edit User'; }
    else { echo 'New User'; }
  echo '    </div>';
  echo '    <div class="panel-body">';
  echo '      <form action="index.php" method="post">';

  echo '      User Full Name:<br>';
  echo '      <input name="name" type="text" size="44" maxlength="50"';
  if ($data['name']) { echo 'value="' . $data['name'] . '"'; }
  echo '>';
  echo '      <br><br>';

  echo '      Username:<br>';
  echo '      <input name="username" type="text" size="44" maxlength="50"';
  if ($data['username']) { echo 'value="' . $data['username'] . '"'; }
  echo '>';
  echo '      <br><br>';

  echo '      <input type="checkbox" name="admin" value="admin"';
  if ($data['admin']) { echo 'checked'; }
  echo '>&nbsp;Admin<br>';

  echo '      <input type="checkbox" name="superuser" value="superuser"';
  if ($data['superuser']) { echo 'checked'; }
  echo '>&nbsp;Superuser<br>';

  echo '      <input type="checkbox" name="user" value="user"';
  if ($data['user']) { echo 'checked'; }
  echo '>&nbsp;user<br>';

  echo '      <br><br>';
  echo '      <input type="hidden" name="action" value="users">';

  if ($edit == "edit") {
    echo '<input type="hidden" name="edit" value="update">';
    echo '<input type="hidden" name="id" value="' . $id. '">';
  }
  else { echo '<input type="hidden" name="edit" value="new">'; }

  echo '      <input class="btn btn-default" type="submit" name="new" value="submit" maxlength="1024">';
  echo '      </form>';
  echo '    </div>';
  echo '  </div>';
}

function showUsers() {
  global $database;

  //fetch user data from issuetracker.users table -->
  $datas=$database->select("users",array("id", "username", "name", "admin", "superuser", "user"));

  echo '<div class="panel panel-default">';
  echo '<div class="panel-heading">';
  echo 'Users';
  echo '</div>';
  echo '<div class="panel-body">';

  echo '<table class="table table-striped">';
  echo '<thead><tr><th>ID</th><th>Username</th><th>Name</th><th>Site Admin</th><th>Superuser</th><th>Active</th><th>Edit</th></tr></thead>';
  echo '<tbody>';

  foreach($datas as $data) {
    echo '<tr>';
    echo '<td>' . $data["id"] . '</td><td>' . $data["username"] . '</td><td>' . $data["name"] . '</td>';
  
    if ($data["admin"] == 1) { echo '<td>Yes</td>'; }
    else { echo '<td>No</td>'; }
  
    if ($data["superuser"] == 1) { echo '<td>Yes</td>'; }
    else { echo '<td>No</td>'; }
  
    if ($data["user"] == 1) { echo '<td>Active</td>'; }
    else { echo '<td>Banned</td>'; }

    echo "<td><a class=\"btn btn-default\" href=\"index.php?action=users&id=" . $data['id'] . "&edit=edit\">Edit</a></td>";
  
    echo '</tr>';
  }

  echo '</tbody></table>';

  // fetch count of all rows in users
  $count = $database->count("users");

  paginate($count);

  echo '</div>';
  echo '</div>';
}

/********************************
 * if edit is set, do something *
 ********************************/

if ($edit == "new") {
  $last_id = $database->insert("users",
    array(
         "name" => "$name",
         "username" => "$username",
         "admin" => "$admin",
         "superuser" => "$superuser",
         "user" => "$user"
         ));
}
elseif ($edit == "update") {
  $database->update("users",
    array(
         "name" => "$name",
         "username" => "$username",
         "admin" => "$admin",
         "superuser" => "$superuser",
         "user" => "$user"),
   array("id[=]" => "$id"));
}

/**************
 * Start html *
 **************/

echo '<div class="container-fluid">';

echo '<div class="col-sm-4">';
newUsers();
echo '</div>'; //end body, box, grid

echo '<div class="col-sm-8">';
showUsers();
echo '</div>';

echo '</div>';

//DEBUG
//echo "<p>edit is $edit</p>";
//echo "<p>id is $id</p>";
//DEBUG END

?>
