<?php
include '../config/db.php'; // yaha $conn hona chahiye mysqli connection

header('Content-Type: application/json');

// 1. Get category
$cat_id = isset($_GET['cat_id']) ? $_GET['cat_id'] : '';
$price = isset($_GET['price']) ? $_GET['price'] : '';
$colors = isset($_GET['color']) ? $_GET['color'] : '';
$size = isset($_GET['size']) ? $_GET['size'] : '';
if ($price != '') {
$total_price_array_count = count($price);
$first_index = $price[0];
$last_index = $price[$total_price_array_count -1];

$query = "SELECT min_price FROM price_ranges WHERE id='$first_index'";
$result = mysqli_query($conn, $query);
$first_min_price = mysqli_fetch_assoc($result);
$filter_by_min_price = $first_min_price['min_price'];

$query2 = "SELECT max_price FROM price_ranges WHERE id='$last_index'";
$result2 = mysqli_query($conn, $query2);
$last_max_price = mysqli_fetch_assoc($result2);
$filter_by_max_price = $last_max_price['max_price'];

 $result = mysqli_query($conn, "SELECT * FROM shop_products where price between '$filter_by_min_price' AND '$filter_by_max_price' limit 0,12");
}else if ($cat_id != '') {

    // 2. Prepare statement
    $result = mysqli_query($conn, "SELECT * FROM shop_products WHERE category_id ='$cat_id'");

} else {
    // No filter
    $result = mysqli_query($conn, "SELECT * FROM shop_products limit 0,12");
}

// 3. Fetch data
$products = [];

while ($row = mysqli_fetch_assoc($result)) {
    $products[] = $row;
}

// 4. Return JSON
echo json_encode($products);
?>