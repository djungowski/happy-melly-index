#!/usr/bin/php
<?php
require_once 'config.php';
require_once 'db.php';

$options = getopt('f:');
if (!isset($options['f'])) {
	print('Error: -f required to specify filename' . PHP_EOL);
	exit(1);
}
$indexFilename = $options['f'];

// Get DB connection
$db = get_db_connection($mysql);

// Start Transaction
$db->beginTransaction();

// Empty table
$db->query('DELETE FROM country');
$db->query('ALTER TABLE country AUTO_INCREMENT=1');

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
	:country,
	:currency,
	:ratio
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
	// substr to eliminate the % char
	$ratio = substr($row[3], 0, -1);
	$stmt = $db->prepare($baseInsertSql);
	$params = array(
		':country'	=> $country,
		':currency'	=> $currency,
		':ratio'	=> $ratio
	);
	$stmt->execute($params);
	printf('Imported country %s' . PHP_EOL, $country);
}

$db->commit();