<?php
session_start();
include '../config/db.php'; // DB path

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../pages/login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $pincode = mysqli_real_escape_string($conn, $_POST['pincode']);
    $locality = mysqli_real_escape_string($conn, $_POST['locality']);
    $full_address = mysqli_real_escape_string($conn, $_POST['full_address']);
    $city = mysqli_real_escape_string($conn, $_POST['city']);
    $state = mysqli_real_escape_string($conn, $_POST['state']);
    $address_type = mysqli_real_escape_string($conn, $_POST['address_type']);

    $sql = "INSERT INTO user_addresses (user_id, name, phone, pincode, locality, full_address, city, state, address_type)
            VALUES ('$user_id', '$name', '$phone', '$pincode', '$locality', '$full_address', '$city', '$state', '$address_type')";

    if ($conn->query($sql) === TRUE) {
        header("Location: ../../pages/addresses.php?status=added");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}
?>