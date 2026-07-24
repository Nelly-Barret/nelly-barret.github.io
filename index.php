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
?>
