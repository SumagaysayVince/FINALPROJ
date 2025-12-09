<?php
$host = "localhost";
$db = "isufst_brainwaves";
$user = "root";
$pass = ""; // change if your XAMPP MySQL has a password

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
