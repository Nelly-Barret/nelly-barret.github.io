<?php 
session_start();
$env = parse_ini_file('.env');
$servername = "localhost";
$username = "nbarret";
$password = $env["MYSQL_PASSWORD"];
$dbname = "nbarret";

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// phpinfo();

$conn = new mysqli($servername, $username, $password, $dbname);
mysqli_set_charset($conn,"utf8");

if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

// function update_table($conn, $the_id, $the_field, $the_id_field, $the_value, $the_table, $allowedFields) {
// 	// variables are not global, so $conn needs to be passed to the function
// 	try {
// 		// Validate field
// 		if (!in_array($the_field, $allowedFields, true)) {
// 			throw new Exception('Invalid field.');
// 		}
	
// 		// Validate project ID
// 		if (!is_numeric($the_id)) {
// 			throw new Exception('Invalid project ID.');
// 		}
	
// 		// Update
// 		$sql = "
// 			UPDATE `$the_table`
// 			SET `$the_field` = ?
// 			WHERE `$the_id_field` = ?
// 		";
	
// 		$stmt = $conn->prepare($sql);
// 		$stmt->bind_param("si", $the_value, $the_id);
// 		$stmt->execute();

// 		if($stmt->affected_rows > 0) {
// 			// Record updated successfully
// 			echo json_encode([
// 				'success' => true
// 			]);
// 		} else {
// 			echo "Error: " . $sql . "<br>" . $conn->error;
// 		}
// 	} catch (Throwable $e) {
// 		http_response_code(500);
// 		echo json_encode([
// 			'success' => false,
// 			'message' => $e->getMessage()
// 		]);
// 	}
// }
?>