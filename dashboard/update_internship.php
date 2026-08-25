<?php
require('../db.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json');

$internship_id = intval($_POST['internship_id']) ?? '';
$field      = $_POST['field'] ?? '';
$value      = $_POST['value'] ?? '';

// Fields that are allowed to be edited
$allowedFields = [
	'start_date', 
	'end_date', 
	'defense_date',
	'manuscript',
	'slides',
	'grade',
	'notes'
];

update_table($conn, $internship_id, $field, "suid", $value, "supervision", $allowedFields);

?>