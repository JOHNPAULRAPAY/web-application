<?php
session_start();

// Protect the page from unauthorized access
if (!isset($_SESSION['user'])) {
  header("Location: index.php");
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Bulletin Board</title>
  
  <!-- Link to your CSS file -->
  <link rel="stylesheet" href="css/forum.css" />
  
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet" />
  
  <!-- Font Awesome -->
  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous" defer></script>
</head>
<body>

  <header>
    <div class="menu-icon">&#9776;</div>
    <h1>Welcome, <?php echo htmlspecialchars($_SESSION['user']); ?>!</h1>

    <!-- Theme toggle switch -->
    <div class="theme-toggle-container">
      <input type="checkbox" id="switch" />
      <label for="switch" class="toggle">
        <span class="btn">
          <span class="dot"></span><span class="dot"></span><span class="dot"></span>
          <span class="dot"></span><span class="dot"></span><span class="dot"></span>
          <span class="dot"></span>
        </span>
        <span class="star"></span><span class="star"></span><span class="star"></span>
        <span class="star"></span><span class="star"></span><span class="star"></span>
        <span class="star"></span><span class="star"></span>
      </label>
    </div>
  </header>

  <div class="section-title">Latest</div>
  <div class="container">
    <div class="post">
      <div class="post-header">Latest Announcement</div>
      <div class="post-content">
        Suspension of classes at all levels (public and private) due to inclement weather.
      </div>
      <img src="images/suspension-image.jpg" alt="Class Suspension" class="post-image" />
    </div>
  </div>

  <div class="section-title">Bulletin</div>
  <div class="container">
    <div class="post">
      <div class="post-header">Dancing no fears: ADT goes fiery and fierce.</div>
      <div class="post-content">
        Congratulations to our <strong>NEW DANCE TROUPE</strong> members who passed the audition.
        We’re excited to see how you’ll continue to excel and inspire in this new journey. 
        <br /><br />
        <em>keep danCing and keep inspir!ng! 💃🕺</em>
      </div>
      <img src="images/dance-troupe-banner.jpg" alt="Dance Troupe" class="post-image" />
    </div>

    <div class="post">
      <div class="post-header">Congratulations Team Hawks! 🦅🏀</div>
      <div class="post-content">
        Great performance by our basketball team. Stay strong and keep flying high!
      </div>
      <img src="images/hawks-team-photo.jpg" alt="Team Photo" class="post-image" />
    </div>
  </div>

  <div class="footer-nav">
    <i class="fa fa-bars"></i>
    <i class="fa fa-home"></i>
    <i class="fa fa-bell"></i>
  </div>

  <br>
  <a href="logout.php" style="margin-left: 20px;">Logout</a>

  <!-- Link your JavaScript file -->
  <script src="js/index.js"></script>
</body>
</html>
