<?php
$conn = new mysqli("localhost", "root", "", "zyrocart");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>