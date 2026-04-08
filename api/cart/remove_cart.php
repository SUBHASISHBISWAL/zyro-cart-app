<?php
session_start();
include '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $cart_id = mysqli_real_escape_string($conn, $_POST['cart_id']);

    // Delete item from cart
    $sql = "DELETE FROM cart WHERE id = '$cart_id' AND user_id = '$user_id'";

    if (mysqli_query($conn, $sql)) {
        // Updated badge count bhejna zaroori hai
        $count_q = mysqli_query($conn, "SELECT SUM(quantity) as total FROM cart WHERE user_id='$user_id'");
        $count_res = mysqli_fetch_assoc($count_q);
        $total_items = $count_res['total'] ? $count_res['total'] : 0;

        echo json_encode(['status' => 'success', 'cart_count' => $total_items]);
    }
}
?>