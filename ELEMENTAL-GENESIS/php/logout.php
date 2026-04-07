<?php
session_start();

// Destroy all session data
$_SESSION = [];
session_destroy();

// Optional: return JSON for JS
header('Content-Type: application/json');
echo json_encode(['success' => true, 'message' => 'Logged out successfully']);
?>