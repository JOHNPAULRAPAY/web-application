<?php
session_start();
include '../../database.php';

$room = $_GET['room'] ?? 'General';

$sql = "SELECT username, text, room, created_at FROM messages WHERE room = ? ORDER BY id ASC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $room);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $isMine = ($row['username'] === ($_SESSION['user'] ?? '')); // ✅ fixed key
    $align = $isMine ? "post--right" : "post--left";

    echo "<div class='post $align'>
            <div class='username'>{$row['username']}</div>
            <div class='bubble'>{$row['text']}</div>
            <div class='time'>".date("h:i A", strtotime($row['created_at']))."</div>
          </div>";
}
