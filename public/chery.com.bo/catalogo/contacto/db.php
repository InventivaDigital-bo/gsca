<?php

$config = array(
	'db_hostname' => 'localhost',
	'db_username' => 'gscacomb_relevan',
	'db_password' => 'b3_2018_relev@nt',
	'db_database' => 'gscacomb_berelevant'
);

$mysqli = new mysqli($config['db_hostname'], $config['db_username'], $config['db_password'], $config['db_database']);
$mysqli->query("SET NAMES 'utf8'");
/*
$now = new DateTime();
$mins = $now->getOffset() / 60;

$sgn = ($mins < 0 ? -1 : 1);
$mins = abs($mins);
$hrs = floor($mins / 60);
$mins -= $hrs * 60;


$offset = sprintf('%+d:%02d', $hrs*$sgn, $mins); // -4:00
*/
$mysqli->query("SET time_zone='-4:00';");

?>