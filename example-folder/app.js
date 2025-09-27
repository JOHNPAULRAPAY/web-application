const chatList = document.getElementById("chatList");
const chatTitle = document.getElementById("chatTitle");
const chatMessages = document.getElementById("chatMessages");
const messageInput = document.getElementById("messageInput");
const sendBtn = document.getElementById("sendBtn");
const newChatBtn = document.getElementById("newChatBtn");

let currentChat = "General";
let chats = {
  "General": []
};

// Switch chat
chatList.addEventListener("click", (e) => {
  if (e.target.classList.contains("chat-item")) {
    document.querySelectorAll(".chat-item").forEach(item => item.classList.remove("active"));
    e.target.classList.add("active");
    currentChat = e.target.dataset.chat;
    chatTitle.textContent = currentChat;
    renderMessages();
  }
});

// Send message
sendBtn.addEventListener("click", sendMessage);
messageInput.addEventListener("keypress", (e) => {
  if (e.key === "Enter") sendMessage();
});

function sendMessage() {
  const text = messageInput.value.trim();
  if (!text) return;
  chats[currentChat].push({ text, sender: "Me" });
  messageInput.value = "";
  renderMessages();
}

function renderMessages() {
  chatMessages.innerHTML = "";
  if (chats[currentChat].length === 0) {
    chatMessages.innerHTML = `<p class="placeholder">No messages here yet...</p>`;
    return;
  }
  chats[currentChat].forEach(msg => {
    const div = document.createElement("div");
    div.classList.add("msg");
    div.textContent = msg.sender + ": " + msg.text;
    chatMessages.appendChild(div);
  });
}

// Create new chat
newChatBtn.addEventListener("click", () => {
  const name = prompt("Enter new chat name:");
  if (!name || chats[name]) return;
  chats[name] = [];
  const li = document.createElement("li");
  li.classList.add("chat-item");
  li.textContent = name;
  li.dataset.chat = name;
  chatList.appendChild(li);
});
