#!/usr/bin/php
<?php
require_once 'config.php';

$options = getopt('f:');
if (!isset($options['f'])) {
	print('Error: -f required to specify filename' . PHP_EOL);
	exit(1);
}
$indexFilename = $options['f'];

// Create DB Connection
$dsn = sprintf('mysql:dbname=%s;host=%s', $mysql['dbname'], $mysql['host']);
$db = new PDO($dsn, $mysql['user'], $mysql['password']);