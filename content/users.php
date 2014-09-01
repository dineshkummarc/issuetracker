<?php

function newUsers() {
echo '  <div class="padded box">';
echo '          <div class="box-header">';
echo '          New User';
echo '          </div>';
echo '          <div class="box-body">';
echo '                  <form action="index.php" method="post" class="padded">';
echo '                  User Full Name:<br>';
echo '                  <input name="name" type="text" size="44" maxlength="50" >';
echo '                  <br><br>';
echo '                  Username:<br>';
echo '                  <input name="username" type="text" size="44" maxlength="50">';
echo '                        <br><br>';
echo '                        <input type="checkbox" name="admin" value="admin">&nbsp;Admin<br>';
echo '                        <input type="checkbox" name="superuser" value="superuser">&nbsp;Superuser<br>';
echo '                        <input type="checkbox" name="user" value="user">&nbsp;user<br>';
echo '                        <br><br>';
echo '                  <input type="hidden" name="action" value="users">';
echo '                  <input type="hidden" name="edit" value="new">';
echo '                  <input type="submit" name="new" value="submit" maxlength="1024">';
echo '                  </form>';
echo '          </div>';
echo '  </div>';
}

function showUsers() {
	global $database;

//fetch user data from issuetracker.users table -->
$datas=$database->select("users",array("id", "username", "name", "admin", "superuser", "user"));

echo '<div class="padded box">';
        echo '<div class="box-header">';
        echo 'Users';
        echo '</div>';
        echo '<div class="box-body">';

echo '<table class="table table-striped">';
echo '<thead><tr><th>ID</th><th>Username</th><th>Name</th><th>Site Admin</th><th>Superuser</th><th>Active</th></tr></thead>';
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

        echo '</tr>';
}

echo '</tbody></table>';

echo '</div>';
echo '</div>';
}

/**************
 * Start html *
 **************/

echo '<div class="grid-container">';

echo '<div class="grid-50">';
showUsers();
echo '</div>'; //end body, box, grid

echo '<div class="grid-50">';
newUsers();
echo '</div> <!-- end grid container -->';

echo '</div>';

?>
