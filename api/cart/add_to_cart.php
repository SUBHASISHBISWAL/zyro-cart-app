<?php
session_start();
include '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = mysqli_real_escape_string($conn, $_POST['product_id']);
    $qty = mysqli_real_escape_string($conn, $_POST['qty']);
    $size = isset($_POST['size']) ? mysqli_real_escape_string($conn, $_POST['size']) : '';
    $color = isset($_POST['color']) ? mysqli_real_escape_string($conn, $_POST['color']) : '';

    // AGAR USER LOGGED IN HAI (Database mein save karo)
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];

        $check = mysqli_query($conn, "SELECT * FROM cart WHERE user_id='$user_id' AND product_id='$product_id' AND size='$size' AND color='$color'");

        if (mysqli_num_rows($check) > 0) {
            mysqli_query($conn, "UPDATE cart SET quantity = quantity + $qty WHERE user_id='$user_id' AND product_id='$product_id' AND size='$size' AND color='$color'");
        } else {
            mysqli_query($conn, "INSERT INTO cart (user_id, product_id, quantity, size, color) VALUES ('$user_id', '$product_id', '$qty', '$size', '$color')");
        }

        $count_q = mysqli_query($conn, "SELECT SUM(quantity) as total FROM cart WHERE user_id='$user_id'");
        $count_res = mysqli_fetch_assoc($count_q);
        $total_items = $count_res['total'] ? $count_res['total'] : 0;

        echo json_encode(['status' => 'success', 'message' => 'Product added to cart!', 'cart_count' => $total_items]);
    }
    // AGAR USER BINA LOGIN KE HAI (Session/Browser memory mein save karo)
    else {
        if (!isset($_SESSION['guest_cart'])) {
            $_SESSION['guest_cart'] = []; // Pehli baar khali cart banao
        }

        // Ek unique key banate hain taaki same size/color wapas aaye toh count badhe
        $item_key = $product_id . '_' . $size . '_' . $color;

        if (isset($_SESSION['guest_cart'][$item_key])) {
            $_SESSION['guest_cart'][$item_key]['qty'] += $qty;
        } else {
            $_SESSION['guest_cart'][$item_key] = [
                'product_id' => $product_id,
                'qty' => $qty,
                'size' => $size,
                'color' => $color
            ];
        }

        // Guest cart ka total count nikalo
        $total_items = 0;
        foreach ($_SESSION['guest_cart'] as $item) {
            $total_items += $item['qty'];
        }

        echo json_encode(['status' => 'success', 'message' => 'Added to cart!', 'cart_count' => $total_items]);
    }
}
?>