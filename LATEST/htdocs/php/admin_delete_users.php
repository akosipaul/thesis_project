<?php
session_start();
require __DIR__ . "/database.php";

header('Content-Type: application/json');

// Only admins can delete users
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo json_encode(['success' => false, 'message' => 'Access denied']);
    exit;
}

// Get user ID to delete
$id = $_POST['id'] ?? 0;

// Get user info
$stmt = $conn->prepare("SELECT username, role FROM users WHERE id = ?");
$stmt->execute([$id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Protect admin account from deletion
if ($user && strtolower($user['username']) === 'admin') {
    echo json_encode(['success' => false, 'message' => '❌ Cannot delete admin account']);
    exit;
}

// Delete user
$stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
if ($stmt->execute([$id])) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Delete failed']);
}