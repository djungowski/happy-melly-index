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
$indexJsonFile = 'js/happy-melly-index.js';

// Open CSV
$filehandle = fopen($indexFilename, "r");
$csvDelimiter = ',';
$csvEnclosure = '"';
$rowNumber = -1;

$index = array();

while (($row = fgetcsv($filehandle, 1000, $csvDelimiter, $csvEnclosure)) !== FALSE) {
	// Skip the first row as it contains the column names
	if ($rowNumber == -1) {
		$rowNumber++;
		continue;
	}
	$name = $row[0];
	$currency = $row[1];
	// substr to eliminate the % char
	$ratio = substr($row[3], 0, -1);

	$country = array(
		'id'		=> $rowNumber,
		'name'		=> $name,
		'currency'	=> $currency,
		'ratio'		=> $ratio
	);

	$index[] = $country;

	printf('Imported country %s' . PHP_EOL, $name);
	$rowNumber++;
}

$output = sprintf('window.happyMellyIndex = %s', json_encode($index));
file_put_contents($indexJsonFile, $output);