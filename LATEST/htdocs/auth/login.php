<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login | Elemental Genesis</title>
  <link rel="stylesheet" href="../css/auth.css">
  <link rel="stylesheet" href="../css/style.css">
  <style>
    .error-message { color: red; font-weight: bold; margin-top: 10px; }
    .success-message { color: green; font-weight: bold; margin-top: 10px; }
  </style>
</head>
<body>
      
<header class="navbar">
  <div class="nav-container">

    <h1 class="logo">
      <img src="../elementalgenesislogo.png" alt="Elemental Genesis Logo" id="secretLogo">
    </h1>

    <div class="menu-toggle" id="menuToggle">&#9776;</div>

    <div class="nav-right" id="navMenu">

      <nav class="nav-links">
        <a href="#about">About</a>
        <a href="#media">Media</a>
        <a href="#download">Download</a>
      </nav>

      <span id="userLabelLi" class="user-label"></span>

      <button class="login-btn" id="loginBtnLi" onclick="goToLogin()">Login</button>
      <button class="logout-btn" id="logoutBtnLi" onclick="logout()">Logout</button>

    </div>

  </div>
</header>

<div class="auth-container">
  <h1>ELEMENTAL GENESIS</h1>
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

    const res = await fetch('../php/login.php', {
      method: 'POST',
      body: formData
    });

    const data = await res.json();

    if (data.success) {
      // Store username in localStorage (optional)
      localStorage.setItem('loggedInUser', username);

      messageEl.textContent = data.message || 'Login successful!';
      messageEl.className = 'success-message';

      // ✅ Correct redirects based on role
      if (data.role === 'admin') {
        window.location.href = '../php/admin.php';
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

document.getElementById("secretLogo").addEventListener("click", () => {
  window.location.href = "../index.php";
});


</script>

</body>
</html>