<?php
require 'database.php';
header('Content-Type: application/json');

try {
    $stmt = $conn->query("SELECT id, username, role FROM users");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (!$users) {
        echo json_encode(['error' => 'No users found']);
    } else {
        echo json_encode($users);
    }
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}