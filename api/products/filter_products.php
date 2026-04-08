<?php
include '../config/db.php'; // yaha $conn hona chahiye mysqli connection

header('Content-Type: application/json');

$inputKeyword = isset($_GET['inputKeyword']) ? $_GET['inputKeyword'] : '';

 $result = mysqli_query($conn,"SELECT * FROM shop_products WHERE name LIKE '%$inputKeyword%'");


    // 3. Fetch data
$products = [];

while ($row = mysqli_fetch_assoc($result)) {
    $products[] = $row;
}
    echo json_encode($products);