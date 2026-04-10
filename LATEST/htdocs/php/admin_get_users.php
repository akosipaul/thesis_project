<?php
session_start();
require __DIR__ . "/database.php";

// Force JSON output
header('Content-Type: application/json');

// Check admin session
if (!isset($_SESSION['username']) || ($_SESSION['role'] ?? '') !== 'admin') {
    http_response_code(403); // Forbidden
    echo json_encode(['error' => 'Access denied. Admins only.']);
    exit();
}

try {
    $stmt = $conn->query("SELECT id, username, role FROM users");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!$users) {
        echo json_encode([]);
    } else {
        echo json_encode($users);
    }
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}