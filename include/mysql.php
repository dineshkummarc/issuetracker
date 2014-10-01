<?php

require_once 'medoo.php';
 
$database = new medoo(array(
	// required
	'database_type' => 'mysql',
	'database_name' => 'issues',
	'server' => 'localhost',
	'username' => 'issuetracker',
	'password' => 'password',

/* Cut out the optional parts, leave in code for future use
	// optional
	'port' => 3306,
	'charset' => 'utf8',
	// driver_option for connection, read more from http://www.php.net/manual/en/pdo.setattribute.php
	'option' => [
		PDO::ATTR_CASE => PDO::CASE_NATURAL
	]
*/

));

?>
