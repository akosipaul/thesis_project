<?php
require 'database.php';
session_start();

if (!isset($_SESSION['username'])) {
    echo json_encode(['success' => false, 'message' => 'Not logged in']);
    exit;
}

// Get user ID
$stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
$stmt->execute([$_SESSION['username']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user) {
    $stmt = $conn->prepare("INSERT INTO downloads (user_id) VALUES (?)");
    $stmt->execute([$user['id']]);
    echo json_encode(['success' => true, 'message' => 'Download recorded']);
}
?>