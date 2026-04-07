<?php
require 'database.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $stmt = $conn->prepare("SELECT id FROM users WHERE username=?");
    $stmt->execute([$username]);
    if (!$stmt->fetch()) {
        echo json_encode(['success'=>false,'message'=>'User not found']);
        exit;
    }

    $hashed = password_hash($password,PASSWORD_DEFAULT);
    $stmt = $conn->prepare("UPDATE users SET password=? WHERE username=?");
    if ($stmt->execute([$hashed,$username])) {
        echo json_encode(['success'=>true,'message'=>'Password updated successfully']);
    } else {
        echo json_encode(['success'=>false,'message'=>'Failed to update password']);
    }
}
?>