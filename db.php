<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "restoran_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set zona waktu menjadi GMT +7
date_default_timezone_set('Asia/Jakarta');

?>
