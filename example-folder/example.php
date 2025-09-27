<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Chat App</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="chat-app">
    
    <!-- Sidebar -->
    <div class="sidebar">
      <div class="sidebar-header">
        <h2>Chats</h2>
        <button id="newChatBtn">＋</button>
      </div>
      <ul id="chatList" class="chat-list">
        <li class="chat-item active" data-chat="General">General</li>
      </ul>
    </div>
    
    <!-- Chat main area -->
    <div class="chat-main">
      <div class="chat-header">
        <h3 id="chatTitle">General</h3>
      </div>
      <div id="chatMessages" class="chat-messages">
        <p class="placeholder">No messages here yet...</p>
      </div>
      <div class="chat-input">
        <input type="text" id="messageInput" placeholder="Write a message...">
        <button id="sendBtn">➤</button>
      </div>
    </div>
    
  </div>
  
  <script src="app.js"></script>
</body>
</html>
