<?php
include '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Get and clean data
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Check if email already exists
    $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        session_start();
        $_SESSION['message'] = "Email already exists ❌";
        header("Location: ../../pages/login.php?tab=signup");
        exit();
    }

    // Insert user
    $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $hashed_password);

    if ($stmt->execute()) {
        session_start();
        $_SESSION['message'] = "Registration successful ✅";
        header("Location: ../../pages/login.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}
?>