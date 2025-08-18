<?php
session_start();
include 'database.php'; // Your DB connection file

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

// Prepare and execute query to get user data
$stmt = $conn->prepare("SELECT password FROM registration WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 1) {
    $stmt->bind_result($hashed_password);
    $stmt->fetch();

    // Verify the password using password_verify
    if (password_verify($password, $hashed_password)) {
        $_SESSION['user'] = $username;
        header("Location: forum/forum.php");
        exit();
    } else {
        header("Location: login.php?error=1");
        exit();
    }
} else {
    // Username not found
    header("Location: login.php?error=1");
    exit();
}
?>
