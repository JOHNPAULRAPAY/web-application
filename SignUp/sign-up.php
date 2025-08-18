<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ACLC Catalog | Sign-Up</title>
    <link rel="icon" href="image/unnamed.png" href="logo.png">
    <link rel="stylesheet" href="sign-up.css">
</head>
<body>
    <div class="box">
        <div class="box-content">
          <h2> SIGN UP</h2><br>
      
          <div class="input-box">
            <form action="../registercon.php" method="post">
            <input required type="text" placeholder="Username" name="username" minlength="5"/>
          </div>
      
          <div class="input-box">
            <input required type="email" placeholder="Email" name="email"/>
          </div>
      
          <div class="input-box">
            <input required minlength="8" maxlength="20" pattern=".{8,20}" title="Password must be 8-20 characters long." type="password" placeholder="Password" name="password"/>
          </div>
      
          <input type="submit" class="button">
          </form>
          <div class="links">
            <a href="../index.php">Already have an account?</a>
            <a href="../index.php">Sign in</a>
          </div>
        </div>
      </div>
      
</body>
</html>