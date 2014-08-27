<?php

//fetch user data from isannointikkk.users table -->
$datas=$database->select("users",array("id", "username", "name", "admin", "superuser", "user"));

echo '<div class="col">';

echo '<div class="col width-1of2">';
echo '<div class="cell panel">';
	echo '<div class="header">';
	echo '<h3>Users:</h3>';
	echo '</div>';
	echo '<div class="body">';

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
echo '</div>'; //end body, panel, col

?>

<!-- add new users form -->
<div class="col width-fill">
	<div class="cell panel">
		<div class="header">
			<h3>New User</h3>
		</div>
		<div class="body">
			<form action="index.php" method="post" class="padded">
			User Full Name:<br>
			<input name="name" type="text" size="44" maxlength="50" >
			<br><br>
			Username:<br>
			<input name="username" type="text" size="44" maxlength="50">
                        <br><br>
                        <input type="checkbox" name="admin" value="admin">&nbsp;Admin<br>
                        <input type="checkbox" name="superuser" value="superuser">&nbsp;Superuser<br>
                        <input type="checkbox" name="user" value="user">&nbsp;user<br>
                        <br><br>
			<input type="hidden" name="action" value="users">
			<input type="hidden" name="edit" value="new">
			<input type="submit" name="new" value="submit" maxlength="1024">
			</form>
		</div>
	</div>
</div>
