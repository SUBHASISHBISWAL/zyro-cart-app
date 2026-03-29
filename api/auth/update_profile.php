<?php
// Error report karne ke liye (taaki blank page na aaye)
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();

// 🔥 SABSE BADI GALTI YAHAN THI (Path fixed: sirf ek bar '../' jayega)
include '../config/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../pages/login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];

    // Form Data
    $name = $_POST['name'];
    $phone = $_POST['phone'];

    // Base query
    $update_query = "UPDATE users SET name='$name', phone='$phone'";

    // Agar user ne photo select ki hai
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['name'] != "") {

        // Image save karne ka path (api/auth se do step peeche root par)
        $target_dir = __DIR__ . "/../../assets/img/users/";

        // Unique file name
        $file_name = time() . "_" . basename($_FILES["profile_image"]["name"]);
        $target_file = $target_dir . $file_name;

        // Image upload logic
        if (move_uploaded_file($_FILES["profile_image"]["tmp_name"], $target_file)) {
            $update_query .= ", profile_image='$file_name'";
        } else {
            die("<h3 style='color:red;'>Error: Image upload fail ho gayi. Linux permissions check karo.</h3>");
        }
    }

    $update_query .= " WHERE id='$user_id'";

    // Database update
    if ($conn->query($update_query) === TRUE) {
        $_SESSION['user_name'] = $name;
        header("Location: ../../pages/profile.php");
        exit();
    } else {
        die("<h3 style='color:red;'>Database Error: " . $conn->error . "</h3>");
    }
} else {
    echo "Invalid Request!";
}
?>