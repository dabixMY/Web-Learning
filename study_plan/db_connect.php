<?php
// Database connection settings — adjust if your local MySQL differs
$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "study_plan";
$port = 3308;

$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name, $port);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>