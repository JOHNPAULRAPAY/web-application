<?php
session_start();
include 'database.php';

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

if ($username && $password) {
    $stmt = $conn->prepare("SELECT password, role FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($stored_password, $role);
        $stmt->fetch();

        if (password_verify($password, $stored_password)) {
            $_SESSION['user'] = $username;
            $_SESSION['role'] = $role;

            if ($role === 'admin') {
                header("Location: admin/admin_dashboard.php");
            } else {
                header("Location: forum/forum.php");
            }
            exit();
        }
    }
}

header("Location: login.php?error=1");
exit();
?>
