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