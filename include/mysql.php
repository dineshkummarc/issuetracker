<?php

/*
$dbuser = "isannointi";
$dbpass = "password";
$dbhost = "localhost";
$dbname = "isannointikkk";
*/

// Independent configuration
require  'medoo.php';
 
$database = new medoo(array(
	// required
	'database_type' => 'mysql',
	'database_name' => 'isannointikkk',
	'server' => 'localhost',
	'username' => 'isannointi',
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

/* example code insert
$database->insert("account", [
	"user_name" => "foo",
	"email" => "foo@bar.com"
]);
*/

?>
