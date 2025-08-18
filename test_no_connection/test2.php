<?php
session_start();
include '../database.php';

// Fetch all courses/subjects
$result = $conn->query("SELECT * FROM courses ORDER BY course_code, year_level, subject_name ASC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard - Manage Courses</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f2f2f2; padding: 20px; }
        h2 { color: #333; }
        form { background: white; padding: 30px; border-radius: 8px; width: 400px; margin-bottom: 20px; }
        input, textarea, select { width: 100%; padding: 10px; margin: 5px 0; }
        button { background: #4CAF50; color: white; border: none; padding: 10px; cursor: pointer; }
        button:hover { background: #45a049; }
        table { width: 100%; border-collapse: collapse; background: white; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: left; }
        th { background: #eee; }
        a.delete { color: red; }
    </style>
</head>
<body>

<h2>Admin Dashboard - Manage Courses</h2>

<?php if (isset($_GET['success'])): ?>
    <p style="color:green;">Course & subjects added successfully!</p>
<?php endif; ?>

<!-- Add Course Form (submits to add_subject.php) -->
<form method="POST" action="add_subject.php">
    <label>Course Code (e.g. BSCS, BSAIS)</label>
    <input type="text" name="course_code" required>

    <label>Year Level</label>
    <select name="year_level" required>
        <option value="">Select Year</option>
        <option value="1">1st Year</option>
        <option value="2">2nd Year</option>
        <option value="3">3rd Year</option>
        <option value="4">4th Year</option>
    </select>

    <label>Subjects (comma-separated)</label>
    <textarea name="subjects" rows="3" placeholder="Enter subjects separated by commas"></textarea>

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
        <th>Action</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['course_code']) ?></td>
            <td><?= $row['year_level'] ?></td>
            <td><?= htmlspecialchars($row['subject_name']) ?></td>
            <td>
                <a href="delete_subject.php?id=<?= $row['id'] ?>" class="delete" onclick="return confirm('Delete this subject?')">Delete</a>
            </td>
        </tr>
    <?php endwhile; ?>
</table>

</body>
</html>
