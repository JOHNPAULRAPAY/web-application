<?php
session_start();
include '../../database.php';

$room = $_GET['room'] ?? 'General';

$stmt = $conn->prepare("SELECT username, text, created_at FROM messages WHERE room = ? ORDER BY id ASC");
$stmt->bind_param("s", $room);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $isUser = ($_SESSION['user'] ?? '') === $row['username'];
    $class = $isUser ? "post post--right" : "post post--left";

    echo "<div class='$class'>
            <div class='username'>{$row['username']}</div>
            <div class='bubble'>{$row['text']}</div>
          </div>";
}
