<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>COURSES</title>
    <link rel="stylesheet" href="course.css">
    <link rel="stylesheet" href="menu.css">
</head>
<body>

<?php  include 'coursemenu.php'?>

    <header>
        <nav class="top-bar">
        <div class="menu-icon" onclick="toggleMenu()">&#9776;</div>
        <div class="title">Selection</div>
        <div class="header-right">
        <img src="../image/unnamed.png" alt="logo.png" class="logo">
        </div>
        </nav>     
    </header>

    <main>
        <div class="selection-box">
            <div class="selection">
                <h2>Course</h2>
                <ul id="course-list">
                    <li><a href="#" data-course="BSAIS">BSAIS</a></li>
                    <li><a href="#" data-course="BSCS">BSCS</a></li>
                    <li><a href="#" data-course="BSEntrep">BSEntrep</a></li>
                </ul>
            </div>
            <div class="selection">
                    <h2>Year</h2>
                    <ul id="year-list">
                        <li><a href="#" data-year="1">1</a></li>
                        <li><a href="#" data-year="2">2</a></li>
                        <li><a href="#" data-year="3">3</a></li>
                        <li><a href="#" data-year="4">4</a></li>
                    </ul>
            </div>
        </div>
    </main>

    <script src="../index.js"></script>


    <script>
        function toggleMenu(){
            const sidebar = document.getElementById('sidebar');
            sidebar.style.width = sidebar.style.width === "200px" ? "0" : "200px";
        }
        </script>

        <script>
            let selectedCourse = null;

        // Highlight clicked course
                const courseLinks = document.querySelectorAll('#course-list a');
                courseLinks.forEach(link => {
                link.addEventListener('click', function (e) {
                    e.preventDefault();
                    selectedCourse = this.dataset.course;

                    // Remove highlight from all, then highlight selected
                    courseLinks.forEach(l => l.classList.remove('selected'));
                    this.classList.add('selected');
                });
                });

                // Handle year selection
                const yearLinks = document.querySelectorAll('#year-list a');
                yearLinks.forEach(link => {
                link.addEventListener('click', function (e) {
                    e.preventDefault();
                    const year = this.dataset.year;

                    if (!selectedCourse) {
                    alert('Please select a course first!');
                    return;
                    }

                    // Redirect to desired page with course and year in query params
                    window.location.href = `CourseSelect/redirectcourse.php?course=${selectedCourse}&year=${year}`;
                });
                });
        </script>
</body>
</html>