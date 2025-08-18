<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Forgot Password</title>
  <link rel="stylesheet" href="forgot-password.css">
</head>
<body>
  <div class="box">
    <div class="box-content">
      <h2>FORGOT PASSWORD</h2><br>
      <form action="send-resetpass.php" method="POST">
        <div class="input-box">
          <input required type="email" name="email" placeholder="Enter your registered email" />
        </div>
        <button class="button" type="submit">Reset Password</button>
      </form>
      <div class="links">
        <a href="../index.php">Back to Login</a>
        <a href="../SignUp/sign-up.php">Sign Up</a>
      </div>
    </div>
  </div>
</body>
</html>
