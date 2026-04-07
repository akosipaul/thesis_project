<?php
require 'database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Check if user exists
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    if ($stmt->fetch()) {
        echo json_encode(['success' => false, 'message' => 'Username already exists']);
        exit;
    }

    // Hash password before saving
    $hashed = password_hash($password, PASSWORD_DEFAULT);

    // Insert user
    $stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, 'user')");
    if ($stmt->execute([$username, $hashed])) {
        echo json_encode(['success' => true, 'message' => 'Account created!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to create account']);
    }
}
?>