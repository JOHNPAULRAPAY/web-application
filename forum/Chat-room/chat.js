const chatList = document.getElementById("chatList");
const chatTitle = document.getElementById("chatTitle");
const chatMessages = document.getElementById("chatMessages");
const messageInput = document.getElementById("messageInput");
const sendBtn = document.getElementById("sendBtn");
const newChatBtn = document.getElementById("newChatBtn");

let currentChat = "General"; // default room

// ✅ Load rooms from DB
function loadRooms() {
  fetch("rooms.php")
    .then(res => res.json())
    .then(rooms => {
      chatList.innerHTML = "";
      rooms.forEach(room => {
        const li = document.createElement("li");
        li.classList.add("chat-item");
        li.textContent = room;
        li.dataset.chat = room;

        if (room === currentChat) li.classList.add("active");

        chatList.appendChild(li);
      });
    });
}

// ✅ Load messages for current room
function loadMessages() {
  fetch("messages.php?room=" + encodeURIComponent(currentChat))
    .then(res => res.text())
    .then(html => {
      chatMessages.innerHTML = html;
      chatMessages.scrollTop = chatMessages.scrollHeight; // auto-scroll
    });
}

// refresh messages every 2s
setInterval(loadMessages, 2000);
loadRooms();
loadMessages();

// ✅ Send message to DB
function sendMessage() {
  const text = messageInput.value.trim();
  if (!text) return;

  fetch("send.php", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: "text=" + encodeURIComponent(text) + "&room=" + encodeURIComponent(currentChat)
  })
  .then(() => {
    messageInput.value = "";
    loadMessages();
  });
}

// Event listeners
sendBtn.addEventListener("click", sendMessage);
messageInput.addEventListener("keypress", (e) => {
  if (e.key === "Enter") {
    e.preventDefault();
    sendMessage();
  }
});

// ✅ Switch chat room
chatList.addEventListener("click", (e) => {
  if (e.target.classList.contains("chat-item")) {
    document.querySelectorAll(".chat-item").forEach(item => item.classList.remove("active"));
    e.target.classList.add("active");
    currentChat = e.target.dataset.chat;
    chatTitle.textContent = currentChat;
    loadMessages();
  }
});

// ✅ Add new chat room
newChatBtn.addEventListener("click", () => {
  const name = prompt("Enter new chat name:");
  if (!name) return;

  fetch("rooms.php", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: "name=" + encodeURIComponent(name)
  })
  .then(res => res.json())
  .then(data => {
    if (data.success) {
      loadRooms(); // refresh rooms list from DB
    } else {
      alert(data.message);
    }
  });
});
