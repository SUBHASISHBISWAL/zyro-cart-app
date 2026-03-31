<?php
include '../config/db.php'; // yaha $conn hona chahiye mysqli connection

header('Content-Type: application/json');

// 1. Get category
$product_id = isset($_GET['product_id']) ? $_GET['product_id'] : '';

$query = "SELECT * FROM shop_products WHERE id='$product_id'";

$result = mysqli_query($conn, $query);
$product = mysqli_fetch_assoc($result);

// 4. Return JSON
echo json_encode($product);
