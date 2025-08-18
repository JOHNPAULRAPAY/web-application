<?php
session_start();
include '../../database.php';

// Get course and year from URL or session
$course = $_GET['course'] ?? $_SESSION['course_name'] ?? "";
$year   = $_GET['year'] ?? $_SESSION['year_level'] ?? "";
$subjects = [];

// Save to session (so details page can still use it)
$_SESSION['course_name'] = $course;
$_SESSION['year_level']  = $year;

// Fetch subjects for the selected course/year
if ($course && $year) {
    $stmt = $conn->prepare("SELECT subject_name FROM courses WHERE course_name = ? AND year_level = ?");
    $stmt->bind_param("si", $course, $year);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $subjects[] = $row['subject_name'];
    }

    $stmt->close();
}
$conn->close();
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($course) . " - " . htmlspecialchars($year); ?></title>
    <link rel="stylesheet" href="redirectcourse.css">
    <link rel="stylesheet" href="../menu.css">
</head>
<body>

<?php include 'menu.php'; ?>

<header>
    <div class="header"> 
        <div class="header-left" onclick="toggleMenu()">&#9776;</div>

        <div class="header-center">
            <?php echo strtoupper($course) . " - " . htmlspecialchars($year); ?>
        </div>

        <div class="header-right">
            <img src="../../image/unnamed.png" alt="logo.png" class="logo">
        </div>
    </div>
</header>

<div class="course-box">
    <h2>COURSE DESCRIPTION</h2>

    <?php if (!empty($subjects)): ?>
        <?php foreach ($subjects as $subject): ?>
            <div class="subject">
                <a href="details/subject_details.php?subject=<?= urlencode($subject) ?>">
                    <?= htmlspecialchars($subject) ?>
                </a>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No subjects found for this course and year level.</p>
        <a href="../courses.php" class="reselect">Go Back</a>
    <?php endif; ?>
</div>

<div class="footer-msg">
    Select any subject to check your Room and Schedule
</div>

<script src="../../index.js"></script>
<script>
    const theme = localStorage.getItem('theme');
    if (theme === 'dark') {
        document.documentElement.classList.add('dark-theme');
    }

    function toggleMenu(){
        const sidebar = document.getElementById("sidebar");
        sidebar.style.width = sidebar.style.width === "200px" ? "0" : "200px";
    }
</script>
</body>
</html>
