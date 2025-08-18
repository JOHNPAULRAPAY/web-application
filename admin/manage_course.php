<?php
session_start();
include '../database.php'; // Your DB connection file

// Check if user is logged in and is admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $subject_id   = trim($_POST['subject_id']);
    $course_name   = trim($_POST['course_name']);
    $schedule_day = $_POST['schedule_day'];
    $schedule_start = $_POST['schedule_start'];
    $schedule_end = $_POST['schedule_end'];
    $room          = trim($_POST['room']);
    $teacher_name  = trim($_POST['teacher_name']);

    $stmt = $conn->prepare("INSERT INTO course (course_code, course_name, schedule_day, schedule_start, schedule_end, room, teacher_name, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, NOW())");
    $stmt->bind_param("issssss", $subject_id , $course_name, $schedule_day, $schedule_start, $schedule_end, $room, $teacher_name);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Course added successfully!";
    } else {
        $_SESSION['message'] = "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();

    header("Location: admin_dashboard.php");
    exit();
} else {
    header("Location: admin_dashboard.php");
    exit();
}
?>
