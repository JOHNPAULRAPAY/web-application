<?php
session_start();
include 'database.php';

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

if ($username && $password) {
    // First, get user info
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
                exit();
            } else if ($role === 'student') {
                // 🔹 Fetch student details
                $stmt2 = $conn->prepare("SELECT course_name, year_level FROM students WHERE username = ?");
                $stmt2->bind_param("s", $username);
                $stmt2->execute();
                $stmt2->bind_result($course_name, $year_level);
                if ($stmt2->fetch()) {
                    $_SESSION['course_name'] = $course_name;
                    $_SESSION['year_level']  = $year_level;
                }
                $stmt2->close();

                header("Location: forum/forum.php");
                exit();
            }
        }
    }
}

header("Location: login.php?error=1");
exit();
?>
