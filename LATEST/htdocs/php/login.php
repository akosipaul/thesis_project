<?php
session_start();
require __DIR__ . "/database.php";

// Return JSON for all responses
header('Content-Type: application/json');

// Default response
$response = ['success' => false, 'message' => 'Unknown error'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (!$username || !$password) {
        $response['message'] = 'Username and password are required';
    } else {
        try {
            // Get user by username
            $stmt = $conn->prepare("SELECT * FROM users WHERE username = :username");
            $stmt->execute(['username' => $username]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                // ✅ Successful login → save session
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

// Send JSON response only
echo json_encode($response);