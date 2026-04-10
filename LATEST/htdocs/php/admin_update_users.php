<?php
require 'database.php';
session_start();
header('Content-Type: application/json');

// Only admins can update users
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo json_encode(['success' => false, 'message' => 'Access denied']);
    exit;
}

$id = $_POST['id'] ?? 0;
$key = $_POST['key'] ?? '';
$value = $_POST['value'] ?? '';

// Prevent admin username or role changes
$stmt = $conn->prepare("SELECT username, role FROM users WHERE id = ?");
$stmt->execute([$id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo json_encode(['success' => false, 'message' => 'User not found']);
    exit;
}

// Protect admin account
if (strtolower($user['username']) === 'admin' && ($key === 'role' || $key === 'username')) {
    echo json_encode(['success' => false, 'message' => 'Cannot change admin role or username']);
    exit;
}

// Hash password if updating
if ($key === 'password') {
    $value = password_hash($value, PASSWORD_DEFAULT);
}

// Update user
$stmt = $conn->prepare("UPDATE users SET $key=? WHERE id=?");
if ($stmt->execute([$value, $id])) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Update failed']);
}