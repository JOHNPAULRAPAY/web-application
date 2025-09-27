<?php 
session_start();
if(!isset($_SESSION['user'])){
  header("location: ../index.php");
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Bulletin Board</title>
  <link rel="stylesheet" href="menu.css">
  <link rel="stylesheet" href="/web-application/forum/forum.css" />
  <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet" />
  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous" defer></script>
</head>
<body>

  <?php include 'menu.php' ?>

  <header>
    <div class="menu-icon" onclick="toggleMenu()">
    &#9776;
    </div>
    <h1>Welcome</h1>

    <!-- Theme toggle switch inside header -->
    <div class="theme-toggle-container">
      <input type="checkbox" id="switch" />
      <label for="switch" class="toggle">
        <span class="btn">
          <span class="dot"></span>
          <span class="dot"></span>
          <span class="dot"></span>
          <span class="dot"></span>
          <span class="dot"></span>
          <span class="dot"></span>
          <span class="dot"></span>
        </span>

        <span class="star"></span>
        <span class="star"></span>
        <span class="star"></span>
        <span class="star"></span>
        <span class="star"></span>
        <span class="star"></span>
        <span class="star"></span>
        <span class="star"></span>
      </label>
    </div>
  </header>

  <div class="section-title">Latest</div>
  <div class="container">
    <div class="post">
      <p>No post yet.</p>
    </div>
  </div>

  <div class="section-title">Bulletin</div>
  <div class="container">
    <div class="post">
      <p>No post yet.</p>
    </div>

    <div class="post">
      <p>No post yet.</p>
    </div>
  </div>

  <div class="footer-nav">
    <i class="fa fa-bars"></i>
    <i class="fa fa-home"></i>
    <i class="fa fa-bell"></i>
  </div>

  <!-- Link your JavaScript file -->
  <script src="../index.js"></script>

  <script> 
    function toggleMenu() {
      const sidebar = document.getElementById("sidebar");
      sidebar.style.width = sidebar.style.width === "200px" ? "0" : "200px";
    }
  </script>
</body>
</html>
