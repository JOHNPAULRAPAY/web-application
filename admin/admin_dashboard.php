<?php
session_start();
include '../database.php';

// Redirect if not admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

// Fetch online users (last 5 minutes)
$onlineUsers = $conn->query("
    SELECT username, last_login 
    FROM users 
    WHERE last_login >= (NOW() - INTERVAL 5 MINUTE)
");

// Fetch activity logs
$logs = $conn->query("
    SELECT users.username, activity_logs.activity, activity_logs.created_at 
    FROM activity_logs
    JOIN users ON activity_logs.user_id = users.id
    ORDER BY activity_logs.created_at DESC 
    LIMIT 10
");

// Fetch distinct courses from `courses` table for dropdown
$courses = $conn->query("SELECT DISTINCT course_name, year_level FROM courses ORDER BY course_name ASC");

// Fetch all subjects
$subjects = $conn->query("SELECT id, course_name, subject_name, subject_code FROM courses ORDER BY course_name ASC, subject_name ASC");
$allSubjects = [];
while($sub = $subjects->fetch_assoc()) {
    $allSubjects[] = $sub;
}

// Fetch scheduled courses
$scheduledCourses = $conn->query("
    SELECT course.id, course.course_name, course.course_code, 
           courses.subject_code, courses.subject_name, 
           course.teacher_name, course.room, course.schedule_day, 
           course.schedule_start, course.schedule_end, courses.year_level
    FROM course
    LEFT JOIN courses ON course.course_code = courses.id
    ORDER BY course.course_name ASC, courses.year_level ASC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../forum/menu.css">
    <style>
        body {
            font-family: "Segoe UI", Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: #f5f7fa;
            color: #333;
        }

        /* Navbar */
        .navbar {
            background: #333;
            overflow: hidden;
        }
        .navbar a {
            float: left;
            display: block;
            color: #f2f2f2;
            text-align: center;
            padding: 14px 20px;
            text-decoration: none;
            font-weight: 500;
        }
        .navbar a:hover {
            background: #4CAF50;
            color: white;
        }

        h1 {
            background: #4CAF50;
            color: #fff;
            padding: 20px;
            margin: 0;
            text-align: center;
            font-size: 28px;
        }

        .section {
            background: #fff;
            margin: 30px auto;
            padding: 25px;
            max-width: 1200px;
            border-radius: 10px;
            border: 1px solid #ddd; 
        }

        .section h2 {
            margin-bottom: 15px;
            font-size: 22px;
            color: #4CAF50;
            border-left: 5px solid #4CAF50;
            padding-left: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            font-size: 14px;
        }
        table th, table td {
            border: 1px solid #e0e0e0;
            padding: 10px 12px;
            text-align: left;
        }
        table th {
            background: #4CAF50;
            color: #fff;
            font-weight: 600;
        }
        table tr:nth-child(even) {
            background: #f9f9f9;
        }
        form {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            flex: 1 1 48%; 
            min-width: 250px; 
        }

        .form-group.full-width {
            flex: 1 1 100%;
        }

        .form-group label {
            font-weight: 500;
            margin-bottom: 5px;
        }

        select, input, textarea, button {
            width: 100%;
            padding: 10px;
            border-radius: 6px;
            border: 1px solid #ccc;
            font-size: 14px;
            background: #fff;
            box-sizing: border-box; 
        }

        button {
            background-color: #4CAF50;
            color: white;
            font-weight: bold;
            border: none;
            cursor: pointer;
            transition: 0.3s;
        }
        button:hover {
            background-color: #43a047;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<div class="navbar">
    <a href="admin_dashboard.php">Dashboard</a>
    <a href="add_subject.php">Add Subject</a>
    <a href="#">Manage Courses</a>
    <a href="#">Manage Users</a>
    <a href="../index.php">Logout</a>
</div>

<h1>Welcome, Admin <?= htmlspecialchars($_SESSION['user']) ?></h1>

<!-- Online Users -->
<div class="section">
    <h2>Online Users</h2>
    <table>
        <tr><th>Username</th><th>Last Login</th></tr>
        <?php while ($user = $onlineUsers->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($user['username']) ?></td>
                <td><?= $user['last_login'] ?></td>
            </tr>
        <?php endwhile; ?>
    </table>
</div>

        <!-- Manage Scheduled Courses -->
        <div class="section">
            <h2>Manage Scheduled Courses</h2>
            <form method="POST" action="manage_course.php">
                
                <!-- Course -->
                <div class="form-group full-width">
                    <label>Course:</label>
                    <select name="course_name" id="course_name" required>
                        <option value="">Select Course</option>
                        <?php while ($course = $courses->fetch_assoc()): ?>
                            <option value="<?= htmlspecialchars($course['course_name']) ?>">
                                <?= htmlspecialchars($course['course_name']) ?> - Year <?= $course['year_level'] ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <!-- Subject + Subject Code -->
        <div class="form-group half">
            <label>Subject:</label>
            <select name="subject_id" id="subject_id" required>
                <option value="">Select Subject</option>
                <?php foreach ($allSubjects as $sub): ?>
                    <option value="<?= htmlspecialchars($sub['id']) ?>" data-code="<?= htmlspecialchars($sub['subject_code']) ?>">
                        <?= htmlspecialchars($sub['subject_name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group half">
            <label>Subject Code:</label>
            <input type="text" id="subject_code" name="subject_code" readonly>
        </div>


        <!-- Teacher + Room -->
        <div class="form-group half">
            <label>Teacher:</label>
            <input type="text" name="teacher_name" placeholder="Teacher Name" required>
        </div>
        <div class="form-group half">
            <label>Room:</label>
            <input type="text" name="room" placeholder="Room" required>
        </div>

        <!-- Schedule Day -->
        <div class="form-group full-width">
            <label>Schedule Day:</label>
            <select name="schedule_day" required>
                <option value="">Select Day</option>
                <option>Monday</option><option>Tuesday</option><option>Wednesday</option>
                <option>Thursday</option><option>Friday</option><option>Saturday</option><option>Sunday</option>
            </select>
        </div>

        <!-- Schedule Start + End -->
        <div class="form-group half">
            <label>Schedule Start:</label>
            <input type="time" name="schedule_start" required>
        </div>
        <div class="form-group half">
            <label>Schedule End:</label>
            <input type="time" name="schedule_end" required>
        </div>

        <!-- Submit -->
        <div class="form-group full-width" style="text-align:center;">
            <button type="submit">Add Scheduled Course</button>
        </div>
    </form>
</div>

<!-- Existing Scheduled Courses -->
<div class="section">
    <h2>Existing Scheduled Courses</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Course/Year Level</th>
            <th>Subject Code</th>
            <th>Subject</th>
            <th>Teacher</th>
            <th>Room</th>
            <th>Day</th>
            <th>Time</th>
            <th>Actions</th>
        </tr>
        <?php while ($course = $scheduledCourses->fetch_assoc()): ?>
            <tr>
                <td><?= $course['id'] ?></td>
                <td><?= htmlspecialchars($course['course_name']) ?> - Year <?= htmlspecialchars($course['year_level']) ?></td>
                <td><?= htmlspecialchars($course['subject_code'] ?? '') ?></td>
                <td><?= htmlspecialchars($course['subject_name'] ?? '') ?></td>
                <td><?= htmlspecialchars($course['teacher_name']) ?></td>
                <td><?= htmlspecialchars($course['room']) ?></td>
                <td><?= htmlspecialchars($course['schedule_day']) ?></td>
                <td>
                    <?= date("g:i A", strtotime($course['schedule_start'])) ?> - 
                    <?= date("g:i A", strtotime($course['schedule_end'])) ?>
                </td>
                <td>
                    <a href="edit_course.php?id=<?= $course['id'] ?>">Edit</a> |
                    <a href="delete_course.php?id=<?= $course['id'] ?>" onclick="return confirm('Delete course?')">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</div>

<!-- Activity Logs -->
<div class="section">
    <h2>Recent Activity Logs</h2>
    <table>
        <tr><th>User</th><th>Activity</th><th>Time</th></tr>
        <?php while ($log = $logs->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($log['username']) ?></td>
                <td><?= htmlspecialchars($log['activity']) ?></td>
                <td><?= $log['created_at'] ?></td>
            </tr>
        <?php endwhile; ?>
    </table>
</div>

<script>
const subjectsData = <?= json_encode($allSubjects) ?>;
const courseSelect = document.getElementById('course_name');
const subjectSelect = document.getElementById('subject_id');
const subjectCodeInput = document.getElementById('subject_code');

courseSelect.addEventListener('change', () => {
    const courseName = courseSelect.value;
    subjectSelect.innerHTML = '<option value="">Select Subject</option>';
    subjectCodeInput.value = '';
    subjectsData.forEach(sub => {
        if (sub.course_name === courseName) {
            const opt = document.createElement('option');
            opt.value = sub.id;
            opt.textContent = sub.subject_name; // ✅ only subject name
            opt.dataset.code = sub.subject_code || '';
            subjectSelect.appendChild(opt);
        }
    });
});

subjectSelect.addEventListener('change', () => {
    const selectedOption = subjectSelect.selectedOptions[0];
    subjectCodeInput.value = selectedOption ? selectedOption.dataset.code : '';
});

</script>

</body>
</html>
