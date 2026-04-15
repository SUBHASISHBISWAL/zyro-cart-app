<?php
session_start();
include '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Clean input
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Check empty
    if (empty($email) || empty($password)) {
        $_SESSION['type'] = "error";
        $_SESSION['message'] = "All fields are required ❌";
        header("Location: ../../pages/login.php");
        exit();
    }

    // Prepared statement (secure)
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {

        $user = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $user['password'])) {

            // Store session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_email'] = $user['email'];

            // ==========================================
            // 🔥 GUEST CART MERGE LOGIC START
            // ==========================================
            if (isset($_SESSION['guest_cart']) && !empty($_SESSION['guest_cart'])) {
                $user_id = $_SESSION['user_id'];

                foreach ($_SESSION['guest_cart'] as $item) {
                    $p_id = $item['product_id'];
                    $qty = $item['qty'];
                    $size = mysqli_real_escape_string($conn, $item['size']);
                    $color = mysqli_real_escape_string($conn, $item['color']);

                    // Check karo ki kya same user ka same product pehle se cart me hai
                    $check_cart = mysqli_query($conn, "SELECT * FROM cart WHERE user_id='$user_id' AND product_id='$p_id' AND size='$size' AND color='$color'");

                    if (mysqli_num_rows($check_cart) > 0) {
                        // Agar pehle se hai toh sirf quantity plus kar do
                        mysqli_query($conn, "UPDATE cart SET quantity = quantity + $qty WHERE user_id='$user_id' AND product_id='$p_id' AND size='$size' AND color='$color'");
                    } else {
                        // Agar naya hai toh insert kar do
                        mysqli_query($conn, "INSERT INTO cart (user_id, product_id, quantity, size, color) VALUES ('$user_id', '$p_id', '$qty', '$size', '$color')");
                    }
                }
                // Database mein sab dalne ke baad, browser ka nakli guest cart delete maar do
                unset($_SESSION['guest_cart']);
            }
            // ==========================================
            // 🔥 GUEST CART MERGE LOGIC END
            // ==========================================

            $_SESSION['type'] = "success";
            $_SESSION['message'] = "Login successful ✅";

            header("Location: ../../index.php");
            exit();

        } else {
            $_SESSION['type'] = "error";
            $_SESSION['message'] = "Wrong Password ❌";
            header("Location: ../../pages/login.php");
            exit();
        }

    } else {
        $_SESSION['type'] = "error";
        $_SESSION['message'] = "User not found ❌";
        header("Location: ../../pages/login.php");
        exit();
    }
}
?>