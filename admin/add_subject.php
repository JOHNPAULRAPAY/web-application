<?php
session_start();
include '../database.php';

// --- Add Course ---
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_course'])) {
    $course_name = $_POST['course_name'];
    $year_level = $_POST['year_level'];
    $subjects = explode(',', $_POST['subjects']);
    $subject_codes = explode(',', $_POST['subject_code']);

    // Loop through both arrays
    for ($i = 0; $i < count($subjects); $i++) {
        $subject_name = trim($subjects[$i]);
        $subject_code = isset($subject_codes[$i]) ? trim($subject_codes[$i]) : "";

        if (!empty($subject_name) && !empty($subject_code)) {
            $stmt = $conn->prepare("INSERT INTO courses (course_name, year_level, subject_name, subject_code) 
                                    VALUES (?, ?, ?, ?)");
            $stmt->bind_param("siss", $course_name, $year_level, $subject_name, $subject_code);
            $stmt->execute();
        }
    }
    echo "<p style='color:green; text-align:center;'>Course & subjects added successfully!</p>";
}

// --- Delete Course ---
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    $conn->query("DELETE FROM courses WHERE id = $delete_id");
    echo "<p style='color:red; text-align:center;'>Subject deleted.</p>";
}

// --- Fetch All ---
$result = $conn->query("SELECT * FROM courses ORDER BY course_name, year_level, subject_name ASC, subject_code ASC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel - Add Subjects</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            background: #f2f2f2; 
            margin:0; 
        }
        h2, h3 { 
            color: #333; 
            text-align: center;
        }
        
        /* Navbar Styles */
        .navbar {
            background: #4CAF50;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: #fff;
        }
        .navbar h1 {
            font-size: 20px;
            margin: 0;
        }
        .navbar a {
            color: white;
            margin-left: 15px;
            text-decoration: none;
            font-weight: bold;
        }
        .navbar a:hover {
            text-decoration: underline;
        }

        /* Main Layout */
        .container { 
            padding:20px; 
            display: flex;
            flex-direction: column;
            align-items: center; /* center horizontally */
        }

        form { 
            background: white; 
            padding: 30px; 
            border-radius: 8px; 
            width: 400px; 
            margin-bottom: 20px; 
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        input, textarea, select { 
            width: 100%; 
            padding: 10px; 
            margin: 5px 0; 
        }
        button { 
            background: #4CAF50; 
            color: white; 
            border: none; 
            padding: 10px; 
            cursor: pointer; 
            width: 100%;
            border-radius: 5px;
        }
        button:hover { background: #45a049; }

        table { 
            width: 80%; 
            border-collapse: collapse; 
            background: white; 
            margin-top: 20px; 
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        th, td { 
            border: 1px solid #ccc; 
            padding: 10px; 
            text-align: center; 
        }
        th { background: #eee; }
        a.delete { color: red; }
    </style>
</head>
<body>

<!-- Navigation Menu -->
<div class="navbar">
    <h1>Admin Panel</h1>
    <div>
        <a href="admin_dashboard.php">🏠 Dashboard</a>
        <a href="#">📚 Manage Courses</a>
        <a href="add_subject.php">➕ Add Subjects</a>
        <a href="../index.php">🚪 Logout</a>
    </div>
</div>

<div class="container">
    <h2>Add Subjects to Courses</h2>

    <!-- Add Course Form -->
    <form method="POST">
        <label>Course Name (e.g. BSCS, BSAIS)</label>
        <input type="text" name="course_name" required>

        <label>Year Level</label>
        <select name="year_level" required>
            <option value="">Select Year</option>
            <option value="1">1st Year</option>
            <option value="2">2nd Year</option>
            <option value="3">3rd Year</option>
            <option value="4">4th Year</option>
        </select>

        <label>Subjects (comma-separated)</label>
        <textarea name="subjects" rows="3" placeholder="Enter subjects"></textarea>

        <label>Subject Codes (comma-separated)</label>
        <textarea name="subject_code" rows="3" placeholder="Enter subject codes"></textarea>

        <button type="submit" name="add_course">Add Course</button>
    </form>

    <!-- Display Courses -->
    <h3>Existing Courses & Subjects</h3>
    <table>
        <tr>
            <th>ID</th>
            <th>Course</th>
            <th>Year Level</th>
            <th>Subject</th>
            <th>Subject Code</th>
            <th>Action</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= htmlspecialchars($row['course_name']) ?></td>
                <td><?= $row['year_level'] ?></td>
                <td><?= htmlspecialchars($row['subject_name']) ?></td>
                <td><?= htmlspecialchars($row['subject_code']) ?></td>
                <td><a href="?delete_id=<?= $row['id'] ?>" class="delete" onclick="return confirm('Delete this subject?')">Delete</a></td>
            </tr>
        <?php endwhile; ?>
    </table>
</div>

</body>
</html>
