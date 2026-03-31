<?php
include '../config/db.php'; // yaha $conn hona chahiye mysqli connection

header('Content-Type: application/json');

// 1. Get category
$cat = isset($_GET['cat']) ? $_GET['cat'] : '';

if ($cat != '') {

    // 2. Prepare statement
    $stmt = mysqli_prepare($conn, "SELECT * FROM shop_products WHERE category = ?");

    // Bind param
    mysqli_stmt_bind_param($stmt, "s", $cat);

    // Execute
    mysqli_stmt_execute($stmt);

    // Get result
    $result = mysqli_stmt_get_result($stmt);

} else {
    // No filter
    $result = mysqli_query($conn, "SELECT * FROM shop_products limit 0,9");
}

// 3. Fetch data
$products = [];

while ($row = mysqli_fetch_assoc($result)) {
    $products[] = $row;
}

// 4. Return JSON
echo json_encode($products);
?>