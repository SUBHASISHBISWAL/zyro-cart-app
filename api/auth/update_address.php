<?php
session_start();
include '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Form se data lena aur secure karna
    $address_id = mysqli_real_escape_string($conn, $_POST['address_id']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $pincode = mysqli_real_escape_string($conn, $_POST['pincode']);
    $locality = mysqli_real_escape_string($conn, $_POST['locality']);
    $full_address = mysqli_real_escape_string($conn, $_POST['full_address']);
    $city = mysqli_real_escape_string($conn, $_POST['city']);
    $state = mysqli_real_escape_string($conn, $_POST['state']);
    $address_type = mysqli_real_escape_string($conn, $_POST['address_type']);

    // Update Query Chalana
    $sql = "UPDATE user_addresses SET
            name = '$name',
            phone = '$phone',
            pincode = '$pincode',
            locality = '$locality',
            full_address = '$full_address',
            city = '$city',
            state = '$state',
            address_type = '$address_type'
            WHERE id = '$address_id' AND user_id = '$user_id'";

    if (mysqli_query($conn, $sql)) {
        header("Location: ../../pages/addresses.php?status=updated");
    } else {
        header("Location: ../../pages/addresses.php?status=error");
    }
    exit();
}
?>