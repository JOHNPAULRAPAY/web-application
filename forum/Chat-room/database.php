<?php
$host = "localhost";
$user = "root";   // default Laragon user
$pass = "";       // default Laragon password is empty
$dbname = "messages";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
