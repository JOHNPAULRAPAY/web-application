<?php
session_start();
include '../database.php';

$id = $_GET['id'] ?? null;
if ($id) {
    $stmt = $conn->prepare("DELETE FROM course WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $_SESSION['message'] = "Course deleted successfully!";
}

header("Location: admin_dashboard.php");
exit();
