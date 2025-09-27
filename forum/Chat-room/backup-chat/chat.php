<?php
session_start();
if (!isset($_SESSION['user'])) {
  header("Location: ../../login.php");
  exit();
}
$username = $_SESSION['user'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Chat Room</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="chat-container">
    <!-- Sidebar -->
    <div class="sidebar">
      <div>
        <h2>Chat Rooms</h2>
        <ul>
          <li>General</li>
          <li>Tech Talk</li>
          <li>Random</li>
        </ul>
      </div>
      <div class="sidebar-footer">
        Logged in as <strong><?php echo htmlspecialchars($username); ?></strong><br>
        <a href="../logout.php" style="color:#aaa;">Logout</a>
      </div>
    </div>

    <!-- Chat Window -->
    <div class="chat-window">
      <div class="chat-header">
        <h2>General Room</h2>
      </div>

      <div class="messages" id="messages"></div>

      <form class="chat-form" id="msgForm">
        <input type="text" id="text" placeholder="Type a message..." required>
        <button type="submit">➤</button>
      </form>
    </div>
  </div>

  <script>
    const USERNAME = "<?php echo htmlspecialchars($username); ?>";

    // Load messages
    function loadMessages() {
      fetch("load.php")
        .then(res => res.text())
        .then(data => {
          document.getElementById("messages").innerHTML = data;
        });
    }
    setInterval(loadMessages, 2000);
    loadMessages();

    // Send message
    document.getElementById("msgForm").addEventListener("submit", function(e) {
      e.preventDefault();
      let text = document.getElementById("text").value;

      fetch("send.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: "username=" + encodeURIComponent(USERNAME) + "&text=" + encodeURIComponent(text)
      }).then(() => {
        document.getElementById("text").value = "";
        loadMessages();
      });
    });
  </script>
</body>
</html>
