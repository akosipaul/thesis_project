<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login | Shadow Protocol</title>
  <link rel="stylesheet" href="../css/auth.css">
  <style>
    /* Optional: make error message red */
    .error-message {
      color: red;
      margin-top: 10px;
      font-weight: bold;
    }
  </style>
</head>
<body>

  <div class="auth-container">
    <h1>NO NAME PA</h1>
    <p>Login to continue</p>

    <form onsubmit="login(event)">
      <input type="text" id="loginUsername" placeholder="Username" required>
      <input type="password" id="loginPassword" placeholder="Password" required>
      <button type="submit">Login</button>
    </form>

    <!-- Error message placeholder -->
    <p id="loginError" class="error-message"></p>

    <p class="switch">
      No account? <a href="signup.php">Sign up</a>
    </p>

    <p class="switch">
      <a href="#" onclick="forgotPassword()">Forgot password?</a>
    </p>
  </div>

  <script src="/elemental-genesis/js/auth.js"></script>
</body>
</html>