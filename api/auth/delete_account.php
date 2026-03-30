<?php
session_start();
include '../config/db.php';

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Delete user from database
    $sql = "DELETE FROM users WHERE id = '$user_id'";

    if ($conn->query($sql) === TRUE) {
        // Destroy session and redirect to Home
        session_unset();
        session_destroy();
        header("Location: ../../index.php?deleted=success");
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }
} else {
    header("Location: ../../pages/login.php");
    exit();
}
?>