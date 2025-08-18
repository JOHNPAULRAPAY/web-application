<?php
session_start();
include '../../../database.php';

// Ensure only students can access
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'student') {
    header("Location: ../login.php");
    exit();
}

// Get student info from session
$student_course_name = $_SESSION['course_name'];
$student_year_level  = $_SESSION['year_level'];

// Query with correct table + column names
$sql = "SELECT 
            courses.subject_code, 
            courses.subject_name, 
            course.teacher_name, 
            course.room, 
            course.schedule_day, 
            course.schedule_start, 
            course.schedule_end
        FROM courses
        LEFT JOIN course 
            ON course.course_code = courses.id  
        WHERE courses.course_name = ? 
          AND courses.year_level = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $student_course_name, $student_year_level);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Subject Details</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #aab3ff;
            text-align: center;
            color: #222;
        }
        body.dark-theme {
            background-color: #121212;
            color: #eee;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 20px;
            background-color: #4267B2;
            color: white;
            border-bottom: 1px solid #ccc;
            font-size: 18px;
            font-weight: bold;
        }
        .header-left, .header-center, .header-right {
            flex: 1;
            text-align: center;
        }
        .header-left { text-align: left; font-size: 1.5em; cursor: pointer; }
        .header-right { text-align: right; }
        .logo { height: 40px; }

        .course-box {
            background: white;
            color: #222;
            margin: 20px auto;
            width: 95%;
            max-width: 900px;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .course-box h2 {
            margin-top: 0;
            padding-bottom: 10px;
            border-bottom: 2px solid #ccc;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            background: #fff;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: center;
        }
        th {
            background: #4267B2;
            color: white;
        }
        .tba {
            color: #888;
            font-style: italic;
        }
        body.dark-theme table {
            background: #2a2a2a;
            color: #eee;
        }
        body.dark-theme th {
            background: #333;
            color: #eee;
        }

        /* Back button inside box */
        .btn-back {
            display: inline-block;
            margin-top: 15px;
            padding: 10px 20px;
            background-color: #4a6cff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }
        .btn-back:hover {
            background-color: #324ecf;
        }
    </style>
</head>
<body>

<div class="header">
    <div class="header-left">&#9776;</div>
    <div class="header-center">Subject Details</div>
    <div class="header-right">
        <img src="../../../image/unnamed.png" alt="logo.png" class="logo">
    </div>
</div>

<div class="course-box">
    <h2>My Subject Details</h2>
    <table>
        <tr>
            <th>Subject Code</th>
            <th>Subject Name</th>
            <th>Teacher</th>
            <th>Room</th>
            <th>Day</th>
            <th>Time</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($row['subject_code']) ?></td>
            <td><?= htmlspecialchars($row['subject_name']) ?></td>
            <td><?= $row['teacher_name'] ? htmlspecialchars($row['teacher_name']) : "<span class='tba'>TBA</span>" ?></td>
            <td><?= $row['room'] ? htmlspecialchars($row['room']) : "<span class='tba'>TBA</span>" ?></td>
            <td><?= $row['schedule_day'] ? htmlspecialchars($row['schedule_day']) : "<span class='tba'>TBA</span>" ?></td>
            <td>
                <?php 
                if ($row['schedule_start'] && $row['schedule_end']) {
                    echo date("g:i A", strtotime($row['schedule_start'])) 
                         . " - " . 
                         date("g:i A", strtotime($row['schedule_end']));
                } else {
                    echo "<span class='tba'>TBA</span>";
                }
                ?>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>

    <!-- Button inside course box -->
    <a href="../redirectcourse.php?course=<?= urlencode($student_course_name) ?>&year=<?= urlencode($student_year_level) ?>" class="btn-back">
        ← Go Back to Course Description
    </a>
</div>

</body>
</html>
