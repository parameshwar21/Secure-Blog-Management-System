<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "blog1";  
$port=3307;

$conn = new mysqli($host, $user, $password, $dbname, port:$port);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>