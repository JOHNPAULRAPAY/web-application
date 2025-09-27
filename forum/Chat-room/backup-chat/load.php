<?php
session_start();
include '../../database.php';

$result = $conn->query("SELECT username, text, created_at FROM messages ORDER BY id ASC");

while ($row = $result->fetch_assoc()) {
    $isUser = ($_SESSION['user'] ?? '') === $row['username'];
    $class = $isUser ? "post post--right" : "post post--left";

    echo "<div class='$class'>
            <!-- Username outside bubble -->
            <div class='username'>{$row['username']}</div>
            
            <!-- Chat bubble -->
            <div class='bubble'>{$row['text']}</div>
          </div>";
}
