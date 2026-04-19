<?php
session_start();
include '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cart_id = mysqli_real_escape_string($conn, $_POST['cart_id']);
    $total_items = 0;

    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        mysqli_query($conn, "DELETE FROM cart WHERE id = '$cart_id' AND user_id = '$user_id'");

        $count_q = mysqli_query($conn, "SELECT SUM(quantity) as total FROM cart WHERE user_id='$user_id'");
        $count_res = mysqli_fetch_assoc($count_q);
        $total_items = $count_res['total'] ? $count_res['total'] : 0;
    } else {
        // Guest Cart Remove
        if (isset($_SESSION['guest_cart'][$cart_id])) {
            unset($_SESSION['guest_cart'][$cart_id]);
        }
        if (isset($_SESSION['guest_cart'])) {
            foreach ($_SESSION['guest_cart'] as $item) {
                $total_items += $item['qty'];
            }
        }
    }

    echo json_encode(['status' => 'success', 'cart_count' => $total_items]);
}
?>