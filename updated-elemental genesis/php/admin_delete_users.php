<?php
require 'database.php';
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo json_encode(['success' => false, 'message' => 'Access denied']);
    exit;
}

$id = $_POST['id'] ?? 0;

$stmt = $conn->prepare("SELECT username FROM users WHERE id = ?");
$stmt->execute([$id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user && strtolower($user['username']) === 'admin') {
    echo json_encode(['success' => false, 'message' => '❌ Cannot delete admin account']);
    exit;
}

$stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
if ($stmt->execute([$id])) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Delete failed']);
}