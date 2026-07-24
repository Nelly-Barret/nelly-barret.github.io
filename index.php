<?php
session_start();
$env = parse_ini_file('.env');
$servername = "localhost";
$username = "nbarret";
$password = $env["MYSQL_PASSWORD"];
$dbname = "nbarret";
echo "Hello";

#mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$conn = new mysqli($servername, $username, $password, $dbname);

if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

echo "Hello 2";

$sql = "SELECT id, first_name, last_name FROM person";
$result = $conn->query($sql);
echo "Hello 3";
if($result->num_rows > 0) {
  echo "Hello 4";
  while($row = $result->fetch_assoc()) {
    echo "- ".$row["first_name"];
  }
  echo "Hello 5";
} else {
  echo "0 result";
}
echo "Hello 6";

echo "Goodbye 0";

try {
	$stmt = $conn->prepare("SELECT * FROM academic_position ap LEFT JOIN description d ON d.fk_id = ap.id ORDER BY ap.id, d.order");
} catch(Exception $e) {
	var_dump($e);
}

echo "Goodbye 1";

/* Prepared statement, stage 2: bind and execute */
// $id = 1;
// $label = 'PHP';
//$stmt->bind_param("is", $id, $label); // "is" means that $id is bound as an integer and $label as a string

$stmt->execute();
echo "Goodbye 2";
$result = $stmt->get_result();

echo "Goodbye 3";
if($result->num_rows > 0) {
  echo "Goodbye 4";
  while($row = $result->fetch_assoc()) {
    echo "- ".$row["title"]."\n";
  }
  echo "Goodbye 5";
} else {
  echo "0 result";
}
echo "Goodbye 6";

?>
