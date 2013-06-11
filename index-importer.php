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

// Open CSV
$filehandle = fopen($indexFilename, "r");
$csvDelimiter = ',';
$csvEnclosure = '"';
$rowNumber = 0;
$baseInsertSql = '
INSERT INTO
	country (
		name,
		currency,
		ratio
	)
VALUES (
	"%s",
	"%s",
	"%b"
)
';
while (($row = fgetcsv($filehandle, 1000, $csvDelimiter, $csvEnclosure)) !== FALSE) {
	$rowNumber++;
	// Skip the first row as it contains the column names
	if ($rowNumber == 1) {
		continue;
	}
	$country = $row[0];
	$currency = $row[1];
	$ratio = substr($row[3], 0, -1);
	var_dump($country, $currency, $ratio);
}