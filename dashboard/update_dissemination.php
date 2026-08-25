<?php
require('../db.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json');

$dissemination_id = intval($_POST['dissemination_id']) ?? '';
$field      = $_POST['field'] ?? '';
$value      = $_POST['value'] ?? '';
$allowedFields = [
	'date',
	'resource',
	'crowd',
	'language'
];

update_table($conn, $dissemination_id, $field, "id", $value, "dissemination", $allowedFields);

?>