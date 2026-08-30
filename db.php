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

?>