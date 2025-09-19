<?php
session_start();
include '../../database.php';

// Add new room
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    if ($name === '') {
        echo json_encode(["success" => false, "message" => "Room name required"]);
        exit;
    }

    $stmt = $conn->prepare("INSERT IGNORE INTO rooms (name) VALUES (?)");
    $stmt->bind_param("s", $name);
    $ok = $stmt->execute();

    echo json_encode(["success" => $ok, "message" => $ok ? "Room added" : "Room already exists"]);
    exit;
}

// Get all rooms
$result = $conn->query("SELECT name FROM rooms ORDER BY id ASC");
$rooms = [];
while ($row = $result->fetch_assoc()) {
    $rooms[] = $row['name'];
}
echo json_encode($rooms);
