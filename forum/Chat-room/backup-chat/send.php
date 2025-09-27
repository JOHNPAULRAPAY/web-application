<?php
session_start();
if (!isset($_SESSION['user'])) exit();

include '../../database.php';

$username = $_SESSION['user'];
$text = $_POST['text'] ?? '';

if ($text !== '') {
    $stmt = $conn->prepare("INSERT INTO messages (username, text, created_at) VALUES (?, ?, NOW())");
    $stmt->bind_param("ss", $username, $text);
    $stmt->execute();
}
