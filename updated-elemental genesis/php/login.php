<?php
ob_start();
session_start();

// Show errors for debugging (remove in production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Connect to database
require __DIR__ . "/database.php";

// Force JSON output
header('Content-Type: application/json');

$response = ['success' => false, 'message' => 'Unknown error'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (!$username || !$password) {
        $response['message'] = 'Username and password required';
    } else {
        try {
            $stmt = $conn->prepare("SELECT * FROM users WHERE username = :username");
            $stmt->execute(['username' => $username]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                // Successful login
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];

                $response['success'] = true;
                $response['role'] = $user['role'];
                $response['message'] = 'Login successful!';
            } else {
                $response['message'] = 'Invalid username or password';
            }
        } catch (PDOException $e) {
            $response['message'] = 'Database error: ' . $e->getMessage();
        }
    }
}

// Send JSON only (no extra HTML)
echo json_encode($response);

ob_end_flush();
?>