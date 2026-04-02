<?php
session_start();
include '../config/db.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Please login first!']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $product_id = mysqli_real_escape_string($conn, $_POST['product_id']);
    $qty = mysqli_real_escape_string($conn, $_POST['qty']);
    $size = isset($_POST['size']) ? mysqli_real_escape_string($conn, $_POST['size']) : '';
    $color = isset($_POST['color']) ? mysqli_real_escape_string($conn, $_POST['color']) : '';

    // Check if item already exists
    $check = mysqli_query($conn, "SELECT * FROM cart WHERE user_id='$user_id' AND product_id='$product_id' AND size='$size' AND color='$color'");

    if (mysqli_num_rows($check) > 0) {
        mysqli_query($conn, "UPDATE cart SET quantity = quantity + $qty WHERE user_id='$user_id' AND product_id='$product_id' AND size='$size' AND color='$color'");
    } else {
        mysqli_query($conn, "INSERT INTO cart (user_id, product_id, quantity, size, color) VALUES ('$user_id', '$product_id', '$qty', '$size', '$color')");
    }

    // Get total items for badge
    $count_q = mysqli_query($conn, "SELECT SUM(quantity) as total FROM cart WHERE user_id='$user_id'");
    $count_res = mysqli_fetch_assoc($count_q);
    $total_items = $count_res['total'] ? $count_res['total'] : 0;

    echo json_encode(['status' => 'success', 'message' => 'Product added to cart!', 'cart_count' => $total_items]);
}
?>