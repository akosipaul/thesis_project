<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login | Shadow Protocol</title>
  <link rel="stylesheet" href="../css/auth.css">
  <style>
    .error-message { color: red; font-weight: bold; margin-top: 10px; }
    .success-message { color: green; font-weight: bold; margin-top: 10px; }
  </style>
</head>
<body>

  <div class="auth-container">
    <h1>NO NAME PA</h1>
    <p>Login to continue</p>

    <form id="loginForm">
      <input type="text" id="loginUsername" name="username" placeholder="Username" required>
      <input type="password" id="loginPassword" name="password" placeholder="Password" required>
      <button type="submit">Login</button>
    </form>

    <p id="loginMessage" class="error-message"></p>

    <p class="switch">
      No account? <a href="signup.php">Sign up</a>
    </p>
    <p class="switch">
      <a href="#" onclick="forgotPassword()">Forgot password?</a>
    </p>
  </div>

  <script>
    async function login(event) {
      event.preventDefault();

      const username = document.getElementById('loginUsername').value.trim();
      const password = document.getElementById('loginPassword').value.trim();
      const messageEl = document.getElementById('loginMessage');

      messageEl.textContent = '';
      messageEl.className = 'error-message';

      if (!username || !password) {
        messageEl.textContent = 'Username and password required';
        return;
      }

      try {
        const formData = new URLSearchParams();
        formData.append('username', username);
        formData.append('password', password);

        // Backend PHP
        const res = await fetch('../php/login.php', {
          method: 'POST',
          body: formData
        });

        const data = await res.json();

        if (data.success) {
          // ✅ Store username in localStorage for index.php
          localStorage.setItem('loggedInUser', username);

          messageEl.textContent = data.message || 'Login successful!';
          messageEl.className = 'success-message';

          // Redirect based on role
          if (data.role === 'admin') {
            window.location.href = '../admin/dashboard.php';
          } else {
            window.location.href = '../index.php';
          }
        } else {
          messageEl.textContent = data.message || 'Invalid username or password';
        }

      } catch (err) {
        messageEl.textContent = 'An error occurred. Try again.';
        console.error(err);
      }
    }

    document.getElementById('loginForm').addEventListener('submit', login);

    function forgotPassword() {
      alert('Password recovery not implemented yet.');
    }
  </script>

</body>
</html>