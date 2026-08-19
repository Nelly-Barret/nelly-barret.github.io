<?php
require('../db.php');
try {
	$mon_champ = $_POST["myfield"];
	// print_r($mon_champ);
	$sql = "INSERT INTO test (champ) VALUES ('".$mon_champ."')";
	$res = $conn->query($sql);

	// if ($conn->query($sql) === TRUE) {
	// 	echo "New record created successfully";
	// } else {
	// 	echo "Error: " . $sql . "<br>" . $conn->error;
	// }

} catch (Exception $e) {
	var_dump($e);
}

?>