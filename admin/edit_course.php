<?php
session_start();
include '../database.php';

// Only allow admins
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

// Get course ID from URL
if (!isset($_GET['id'])) {
    echo "No course selected.";
    exit();
}

$id = intval($_GET['id']);

// Fetch course data
$stmt = $conn->prepare("SELECT * FROM course WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$course = $result->fetch_assoc();

if (!$course) {
    echo "Course not found.";
    exit();
}

// Update course when form submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $course_name   = $_POST['course_name'];
    $course_code   = $_POST['course_code'];
    $teacher_name  = $_POST['teacher_name'];
    $room          = $_POST['room'];
    $schedule_date = $_POST['schedule_date']; // YYYY-MM-DD
    $schedule_time = $_POST['schedule_time']; // HH:MM

    $update = $conn->prepare("UPDATE course 
        SET course_name=?, course_code=?, teacher_name=?, room=?, schedule_date=?, schedule_time=? 
        WHERE id=?");
    $update->bind_param("ssssssi", $course_name, $course_code, $teacher_name, $room, $schedule_date, $schedule_time, $id);
    $update->execute();

    header("Location: admin_dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Course</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        input, button { padding: 8px; margin: 5px 0; width: 300px; }
    </style>
</head>
<body>

<h2>Edit Course</h2>
<form method="POST">
    <input type="text" name="course_name" value="<?= htmlspecialchars($course['course_name']) ?>" placeholder="Course Name" required><br>
    <input type="text" name="course_code" value="<?= htmlspecialchars($course['course_code']) ?>" placeholder="Course Code" required><br>
    <input type="text" name="teacher_name" value="<?= htmlspecialchars($course['teacher_name']) ?>" placeholder="Teacher Name" required><br>
    <input type="text" name="room" value="<?= htmlspecialchars($course['room']) ?>" placeholder="Room" required><br>

    <!-- Schedule Date -->
    <input type="date" name="schedule_day" value="<?= htmlspecialchars($course['schedule_day']) ?>" required><br>

    <!-- Schedule Time -->
    <input type="time" name="schedule_time" value="<?= htmlspecialchars(substr($course['schedule_time'], 0, 5)) ?>" required><br>

    <button type="submit">Update Course</button>
</form>

<a href="admin_dashboard.php">Cancel</a>

</body>
</html>
