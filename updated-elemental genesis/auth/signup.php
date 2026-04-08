<?php
// auth/signup.php
require '../php/database.php';

// Only handle POST requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');

    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (!$username || !$password) {
        echo json_encode(['success' => false, 'message' => 'Username and password required']);
        exit;
    }

    try {
        // Check if username exists
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->execute(['username' => $username]);
        if ($stmt->fetch(PDO::FETCH_ASSOC)) {
            echo json_encode(['success' => false, 'message' => 'Username already exists']);
            exit;
        }

        // Hash password
        $hashed = password_hash($password, PASSWORD_DEFAULT);

        // Insert new user
        $stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (:username, :password, 'user')");
        if ($stmt->execute(['username' => $username, 'password' => $hashed])) {
            echo json_encode(['success' => true, 'message' => 'Account created!']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to create account']);
        }

    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    }

    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign Up | Shadow Protocol</title>
  <link rel="stylesheet" href="../css/auth.css">
  <style>
    .signup-message { font-weight: bold; margin-top: 10px; }
    .signup-error { color: red; }
    .signup-success { color: green; }
  </style>
</head>
<body>

  <div class="auth-container">
    <h1>Create Account</h1>
    <p>Join Shadow Protocol</p>

    <form id="signupForm">
      <input type="text" id="signupUsername" placeholder="Username" required>
      <input type="password" id="signupPassword" placeholder="Password" required>
      <button type="submit">Sign Up</button>
    </form>

    <p id="signupMessage" class="signup-message"></p>

    <p class="switch">
      Already have an account? <a href="login.php">Login</a>
    </p>
  </div>

  <script>
    async function signup(event) {
      event.preventDefault();

      const username = document.getElementById('signupUsername').value.trim();
      const password = document.getElementById('signupPassword').value.trim();
      const messageEl = document.getElementById('signupMessage');

      messageEl.textContent = '';
      messageEl.className = 'signup-message signup-error';

      if (!username || !password) {
        messageEl.textContent = 'Username and password required';
        return;
      }

      try {
        const formData = new URLSearchParams();
        formData.append('username', username);
        formData.append('password', password);

        const res = await fetch('', { // POST to same page
          method: 'POST',
          body: formData
        });

        const data = await res.json();

        if (data.success) {
          messageEl.textContent = data.message || 'Account created!';
          messageEl.className = 'signup-message signup-success';

          // ✅ Redirect to login page after 1 second
          setTimeout(() => {
            window.location.href = 'login.php';
          }, 1000);
        } else {
          messageEl.textContent = data.message || 'Signup failed';
        }

      } catch (err) {
        messageEl.textContent = 'An error occurred. Try again.';
        console.error(err);
      }
    }

    document.getElementById('signupForm').addEventListener('submit', signup);
  </script>

</body>
</html>
