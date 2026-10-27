<?php
require('../db.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json');

$project_id = intval($_POST['project_id']) ?? '';
$field      = $_POST['field'] ?? '';
$value      = $_POST['value'] ?? '';
$allowedFields = [
	'opening_date',
	'deadline1',
	'deadline2',
	'start_date', 
	'end_date', 
	'status',
	'notes'
];

update_table($conn, $project_id, $field, "prid", $value, "project", $allowedFields);

?>