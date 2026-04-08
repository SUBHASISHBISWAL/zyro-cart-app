<?php
session_start();
include '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $cart_id = mysqli_real_escape_string($conn, $_POST['cart_id']);
    $qty = mysqli_real_escape_string($conn, $_POST['qty']);

    // Update quantity
    if ($qty > 0) {
        $sql = "UPDATE cart SET quantity = '$qty' WHERE id = '$cart_id' AND user_id = '$user_id'";
        mysqli_query($conn, $sql);
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Quantity must be at least 1']);
    }
}
?>