<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign Up | Shadow Protocol</title>
  <link rel="stylesheet" href="../css/auth.css">
</head>
<body>

  <div class="auth-container">
    <h1>Create Account</h1>
    <p>Join Shadow Protocol</p>

    <form onsubmit="signup(event)">
      <input type="text" id="signupUsername" placeholder="Username" required>
      <input type="password" id="signupPassword" placeholder="Password" required>
      <button type="submit">Sign Up</button>
    </form>

    <p id="signupMessage" class="signup-message"></p>

    <p class="switch">
      Already have an account? <a href="login.php">Login</a>
    </p>
  </div>

  <script src="/elemental-genesis/js/auth.js"></script>
</body>
</html>
