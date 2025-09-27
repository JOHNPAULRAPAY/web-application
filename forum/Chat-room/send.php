<?php
session_start();
include '../../database.php';

if (!isset($_SESSION['user'])) {
    http_response_code(401);
    echo "Not logged in";
    exit;
}

$username = $_SESSION['user']; // ✅ match login.php
$text = $_POST['text'] ?? '';
$room = $_POST['room'] ?? 'General';

if (trim($text) !== '') {
    $stmt = $conn->prepare("INSERT INTO messages (username, text, room, created_at) VALUES (?, ?, ?, NOW())");
    $stmt->bind_param("sss", $username, $text, $room);
    $stmt->execute();
}
?>
