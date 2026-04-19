<?php
session_start();
include '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cart_id = mysqli_real_escape_string($conn, $_POST['cart_id']);
    $qty = (int)$_POST['qty'];

    if ($qty > 0) {
        if (isset($_SESSION['user_id'])) {
            $user_id = $_SESSION['user_id'];
            mysqli_query($conn, "UPDATE cart SET quantity = '$qty' WHERE id = '$cart_id' AND user_id = '$user_id'");
        } else {
            // Guest Cart Update
            if (isset($_SESSION['guest_cart'][$cart_id])) {
                $_SESSION['guest_cart'][$cart_id]['qty'] = $qty;
            }
        }
        echo json_encode(['status' => 'success']);
    }
}
?>