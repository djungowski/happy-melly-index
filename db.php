<?php
function get_db_connection($mysql) {
	// Create DB Connection
	$dsn = sprintf('mysql:dbname=%s;host=%s', $mysql['dbname'], $mysql['host']);
	$db = new PDO($dsn, $mysql['user'], $mysql['password']);
	return $db;
}