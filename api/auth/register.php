<?php
 include '../config/db.php';
if($_SERVER['REQUEST_METHOD'] == 'POST'){
$name = $_POST['name'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

// Insert query
$sql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')";

if ($conn->query($sql) === TRUE) {
header("Location: ../../pages/login.php");
exit();
} else {
    echo "Error: " . $conn->error;
}
}
?>