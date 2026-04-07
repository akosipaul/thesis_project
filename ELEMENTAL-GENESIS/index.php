<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>ELEMENTAL GENESIS</title>
  <link rel="stylesheet" href="css/style.css">
</head>

<body>

  <!-- NAVBAR -->
  <header class="navbar">
    <div class="nav-container">
      <h1 class="logo">ELEMENTAL GENESIS</h1>

      <div class="nav-right">
        <nav class="nav-links">
          <a href="#about">About</a>
          <a href="#media">Media</a>
          <a href="#download">Download</a>
        </nav>

        <!-- USERNAME LABEL -->
        <span id="userLabel" class="user-label"></span>

        <button class="login-btn" id="loginBtn" onclick="goToLogin()">Login</button>
        <button class="logout-btn" id="logoutBtn" onclick="logout()">Logout</button>

      </div>
    </div>
  </header>

  <!-- HERO -->
  <section class="hero">
    <div class="hero-content">
      <h2>ENTER THE WORLD OF ELEMENTAL GENESIS</h2>
      <p>A 3D civilization-building game where you mine elements, craft compounds, battle monsters, and learn chemistry through gameplay.</p>
      <a href="#download" class="btn">Download Now</a>
    </div>
  </section>

  <!-- ABOUT -->
  <section class="about" id="about">
    <h2>About the Game</h2>
    <p>Elemental Genesis is a 3D educational game designed for SHS STEM students to learn General Chemistry through interactive gameplay. 
      Players explore an open world, collect elements through mining and combat, and combine them to form compounds used to build and expand their civilization.
      With features like crafting, equipment systems, NPC quests, and an in-game shop, the game creates an engaging environment where students can apply chemistry concepts in real-time.
      Elemental Genesis transforms abstract lessons into hands-on experiences, making learning more fun, practical, and effective.
    </p>
  </section>

  <!-- MEDIA -->
  <section class="media" id="media">
    <h2>Game Preview</h2>
    <div class="media-box">
      <img src="1.png" alt="Game Image 1" class="media-image">
      <img src="2.png" alt="Game Image 2" class="media-image">
      <img src="gamep_1.png" alt="Game Image 3" class="media-image">
    </div>
  </section>

  <!-- DOWNLOAD -->
  <section class="download" id="download">
    <h2>Download</h2>
    <p>Available on Mobile</p>
    <button onclick="downloadGame()">Download Installer</button>
  </section>

  <!-- FOOTER -->
  <footer>
    <p>© 2026 NONAME. All Rights Reserved.</p>
  </footer>

  <!-- MAIN JS -->
  <script src="js/main.js"></script>

  <!-- SHOW USERNAME & HIDE LOGOUT IF NOT LOGGED IN -->
  <script>
    const logoutBtn = document.getElementById("logoutBtn");
    const loginBtn = document.getElementById("loginBtn");
    const userLabel = document.getElementById("userLabel");

    const loggedInUser = localStorage.getItem("loggedInUser");

    if (loggedInUser) {
    // USER IS LOGGED IN
      userLabel.textContent = loggedInUser;
      loginBtn.style.display = "none";
    } else {
    // USER IS NOT LOGGED IN
      userLabel.style.display = "none";
      logoutBtn.style.display = "none";
    }

    function goToLogin() {
      window.location.href = "auth/login.php";
    }
  </script>


</body>
</html>
