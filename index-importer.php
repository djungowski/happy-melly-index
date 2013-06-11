#!/usr/bin/php
<?php

$options = getopt('f:');
if (!isset($options['f'])) {
	print('Error: -f required to specify filename' . PHP_EOL);
	exit(1);
}
$indexFilename = $options['f'];