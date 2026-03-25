
<?php
session_start();
 include '../config/db.php';
$email = $_POST['email'];
$password = $_POST['password'];
$sql = "SELECT * FROM users WHERE email='$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();

    // Verify password
    if (password_verify($password, $user['password'])) {

       $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_email'] = $user['email'];
       header("Location: ../../index.php");
    } else {
        $_SESSION['message'] = "Wrong Password";
          header("Location: ../../pages/login.php");
    }
} else {
    $_SESSION['message'] = "User not found";
          header("Location: ../../pages/login.php");
}
?>