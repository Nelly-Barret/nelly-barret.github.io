<?php
require('../db.php');
try {
	$myid = $_POST["myid"];
	$mon_champ = $_POST["myfield"];
	$sql = "UPDATE test SET champ = '".$mon_champ."' WHERE id=".$myid;
	$res = $conn->query($sql);

	if ($conn->query($sql) === TRUE) {
		echo "Record updated successfully";
	} else {
		echo "Error: " . $sql . "<br>" . $conn->error;
	}

} catch (Exception $e) {
	var_dump($e);
}

?>