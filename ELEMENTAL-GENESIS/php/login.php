<?php
require 'database.php';
session_start();

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if (!$username || !$password) {
        echo json_encode(['success'=>false,'message'=>'Username and password required']);
        exit;
    }

    // Prepare and execute
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        echo json_encode(['success'=>true,'role'=>$user['role']]);
    } else {
        echo json_encode(['success'=>false,'message'=>'Invalid username or password']);
    }
}
?>