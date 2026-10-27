<?php
require('../db.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json');

$service_id = intval($_POST['service_id']) ?? '';
$field      = $_POST['field'] ?? '';
$value      = $_POST['value'] ?? '';
$allowedFields = [
	'year',
	'role'
];

update_table($conn, $service_id, $field, "seid", $value, "service", $allowedFields);

?>