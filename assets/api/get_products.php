<?php
include 'db_connect.php';
header('Content-Type: application/json');

// 1. Get the category from the AJAX request (e.g., ?cat=Men)
$cat = isset($_GET['cat']) ? $_GET['cat'] : '';

// 2. Prepare the SQL using your new table name: shop_products
if ($cat != '') {
    // If a category is selected, filter the results
    $stmt = $pdo->prepare("SELECT * FROM shop_products WHERE category = ?");
    $stmt->execute([$cat]);
} else {
    // If no category is selected, get everything from shop_products
    $stmt = $pdo->query("SELECT * FROM shop_products");
}

// 3. Fetch all rows as an associative array
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// 4. Send the data back to your AJAX script in JSON format
echo json_encode($products);
?>