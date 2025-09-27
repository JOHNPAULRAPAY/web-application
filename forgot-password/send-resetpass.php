<?php
// Include DB connection
include '../database.php';

$email = $_POST['email'] ?? '';

if ($email) {
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        // You would generate a token and send email here
        echo "<script>alert('Password reset instructions sent to your email.'); window.location.href = '../index.php';</script>";
    } else {
        echo "<script>alert('Email not found.'); window.history.back();</script>";
    }
} else {
    echo "<script>alert('Please enter your email.'); window.history.back();</script>";
}
?>
