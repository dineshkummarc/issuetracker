<?php

echo '<div class="col">';
echo '<div class="col width-1of3">';

if (!isset($reentry)) { $reentry = "0"; }

if ($reentry == "1") {

        echo '<div class="cell panel">';
        echo '  <div class="header">';
        echo '   <p>Update Issue Type:</p>';
        echo '  </div>';
        echo '<div class="body">';

        $datas = $database->select("issuetypes","*",array( "id[=]" => $id ));

        foreach ($datas as $data) {
                echo '<form action="index.php" method="post" class="padded">';
                echo '<input type="hidden" name="action" value="editissues">';
                echo '<input type="hidden" name="edit" value="update">';
                echo '<input type="hidden" name="id" value="' . $data["id"] . '">';

                echo 'Issue Short Description:<br>';
                echo '<input name="issuetype" type="text" size="40" maxlength="128" value="' . $data["type"] . '">';
                echo '<br><br>'; 
                echo 'Issue Long Description:<br>';
                echo '<textarea name="description" cols="40" rows="8">' . $data["description"] . '</textarea><br><br>';
                echo '<input type="submit" name="Add &raquo;" value="Update" maxlength="1024">';
                echo '<a class="button right" href="index.php?action=editissues">RESET</a>';
                echo '</form>';  
        }

        echo '</div></div>';
}

if ($reentry == "0") {

        echo '<div class="cell panel">';
        echo '  <div class="header">';
        echo '   <p>New Issue Type:</p>';
        echo '  </div>';
        echo '<div class="body">';

        echo '<form action="index.php" method="post" class="padded">';
        echo '<input type="hidden" name="action" value="editissues">';
        echo '<input type="hidden" name="edit" value="new">';

        // issue types dropdown
        echo 'Issue Short Description:<br>';
        echo '<input name="issuetype" type="text" size="40" maxlength="128" >';
        echo '<br><br>';
        echo 'Issue Long Description:<br>';
        echo '<textarea name="description" cols="40" rows="8"></textarea><br><br>';
        echo '<input type="submit" name="Add &raquo;" value="New" maxlength="1024">';
        echo '<a class="button right" href="index.php?action=editissues">RESET</a>';
        echo '</form>';

        echo '</div></div>';
}

//end column div
echo '</div>';

echo '<div class="col width-fill">';
echo '<div class="cell panel">';
echo '  <div class="header">';
echo '   <p>Issue List:</p>';
echo '  </div>';
echo '<div class="body">';

$datas = $database->select("issuetypes","*");

	echo '<table class="table horizontal-border">';
	echo '<thead><tr><th>ID</th><th>Issue Type</th><th>Description</th><th></th></tr></thead>';
	echo '<tbody>'; 

foreach($datas as $data) {
        echo '<tr>';
        echo '<td>' . $data["id"] . '</td>';
	echo '<td>' . $data["type"] . '</td>';
	echo '<td>' . $data["description"] . '</td>';
        echo '<td><form action="index.php" class="padded" method="post">';
        echo '<input type="hidden" name="action" value="editissues">';
        echo '<input type="hidden" name="id" value="' . $data["id"] . '">';
        echo '<button type="submit" name="edit" value="edit">Edit</button>';
	echo '</form></td>';
        echo '</tr>';
}

        echo '</tbody>';
        echo '</table>';

echo '</div></div>'; //end body, end cell
echo '</div>'; // end col

?>
