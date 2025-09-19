<?php
session_start();
include '../../database.php';

if (!isset($_SESSION['user'])) exit();

$user = $_SESSION['user'];
$text = $_POST['text'] ?? '';
$room = $_POST['room'] ?? 'General';

if ($text) {
    $stmt = $conn->prepare("INSERT INTO messages (username, text, room, created_at) VALUES (?, ?, ?, NOW())");
    $stmt->bind_param("sss", $user, $text, $room);
    $stmt->execute();
}
