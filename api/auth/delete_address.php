<?php
session_start();
include '../config/db.php'; // DB path

if (!isset($_SESSION['user_id']) || !isset($_GET['id'])) {
    header("Location: ../../pages/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$address_id = mysqli_real_escape_string($conn, $_GET['id']);

$sql = "DELETE FROM user_addresses WHERE id = '$address_id' AND user_id = '$user_id'";

if ($conn->query($sql) === TRUE) {
    header("Location: ../../pages/addresses.php?status=deleted");
    exit();
} else {
    echo "Error deleting record: " . $conn->error;
}
?>