<?php

//fetch user data from issuetracker.users table -->
$datas=$database->select("users",array("id", "username", "name", "admin", "superuser", "user"));

echo '<div class="grid-container">';

echo '<div class="grid-50">';
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
echo '</div>'; //end body, box, grid

?>

<!-- add new users form -->
<div class="grid-50">
	<div class="padded box">
		<div class="box-header">
		New User
		</div>
		<div class="box-body">
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

</div> <!-- end grid container -->
