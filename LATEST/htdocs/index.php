<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Elemental Genesis BETA</title>

  <link rel="stylesheet" href="css/style.css">
</head>

<body>

<!-- =========================
     NAVBAR
========================= -->
<header class="navbar">
  <div class="nav-container">

    <h1 class="logo">
      <img src="elementalgenesislogo.png" alt="Elemental Genesis Logo" id="secretLogo">
    </h1>

    <div class="menu-toggle" id="menuToggle">&#9776;</div>

    <div class="nav-right" id="navMenu">

      <nav class="nav-links">
        <a href="#about">About</a>
        <a href="#media">Media</a>
        <a href="#download">Download</a>
      </nav>

      <span id="userLabel" class="user-label"></span>

      <button class="login-btn" id="loginBtn" onclick="goToLogin()">Login</button>
      <button class="logout-btn" id="logoutBtn" onclick="logout()">Logout</button>

    </div>

  </div>
</header>

<!-- =========================
     HERO
========================= -->
<section class="hero">
  <div class="hero-content">
    <h2>ENTER THE WORLD OF ELEMENTAL GENESIS</h2>
    <p>
      A 3D civilization-building game where you mine elements, craft compounds, battle monsters, and learn chemistry through gameplay.
    </p>
    <a href="#download" class="btn">Download Now</a>
  </div>
</section>

<!-- =========================
     ABOUT
========================= -->
<section class="about" id="about">
  <h2>About the Game</h2>
  <p>
    Elemental Genesis is a 3D educational game designed for SHS STEM students to learn General Chemistry through interactive gameplay. Players explore an open world, collect elements, craft compounds, and build civilizations while learning real chemistry concepts.
  </p>
</section>

        
        
<section class="how-to-play" id="howtoplay">

  <h2>How You Play</h2>
  <p class="how-subtitle">
    Master the cycle of progression in Elemental Genesis.
  </p>

  <div class="flow">

    <div class="step-card">⛏ Harvesting</div>
    <div class="arrow">→</div>

    <div class="step-card">⚗ Crafting</div>
    <div class="arrow">→</div>

    <div class="step-card">🏗 Building</div>
    <div class="arrow">→</div>

    <div class="step-card">⚔ Combat</div>

  </div>

</section>
        
        
<!-- =========================
     MEDIA
========================= -->
<section class="media" id="media">
  <h2>Game Preview</h2>

  <div class="media-box">
    <img src="eg1.png" class="media-image" alt="Game Image 1">
    <img src="egd1.png" class="media-image" alt="Game Image 2">
    <img src="egcombat1.png" class="media-image" alt="Game Image 3">
  </div>
</section>

<!-- =========================
     DOWNLOAD
========================= -->
<section class="download" id="download">
  <h2>Download</h2>
  <p>Available on Mobile</p>
  <button onclick="downloadGame()">Download Installer</button>
</section>

<!-- =========================
     FOOTER
========================= -->


<!-- =========================
     LIGHTBOX
========================= -->
<div id="lightbox" class="lightbox">
  <span class="close">&times;</span>
  <img id="lightboxImg" class="lightbox-img">

  <button class="prev">&#10094;</button>
  <button class="next">&#10095;</button>
</div>
      
<footer>
  <p>© 2026 Elemental Genesis. All Rights Reserved.</p>
</footer>

<!-- =========================
     JS
========================= -->
<script>
document.addEventListener("DOMContentLoaded", () => {
    
	const steps = document.querySelectorAll(".step-card");

	steps.forEach((step, index) => {
  		step.style.opacity = "0";
 	 	step.style.transform = "translateY(20px)";

  		setTimeout(() => {
    		step.style.transition = "all 0.5s ease";
    		step.style.opacity = "1";
    		step.style.transform = "translateY(0)";
  		}, index * 200);
	});
    const cards = document.querySelectorAll(".card");

	cards.forEach(card => {
  		card.addEventListener("click", () => {
    
    // if already active → close it
    		if (card.classList.contains("flipped")) {
      			card.classList.remove("flipped");
      			document.body.classList.remove("focus-mode");
      			cards.forEach(c => c.classList.remove("dim"));
      			return;
    		}

    // reset all cards
    		cards.forEach(c => {
            	c.classList.remove("flipped");
                c.classList.add("dim");
    		});

    // activate clicked card
    		card.classList.add("flipped");
    		document.body.classList.add("focus-mode");

    // remove dim from active card
    		card.classList.remove("dim");
  			});
	});

  /* =========================
     NAVBAR TOGGLE
  ========================= */
  const toggle = document.getElementById("menuToggle");
  const nav = document.getElementById("navMenu");

  toggle.addEventListener("click", () => {
    nav.classList.toggle("active");
  });

  /* =========================
     LOGIN SYSTEM
  ========================= */
  const userLabel = document.getElementById("userLabel");
  const loginBtn = document.getElementById("loginBtn");
  const logoutBtn = document.getElementById("logoutBtn");

  const user = localStorage.getItem("loggedInUser");

  function updateUI() {
    if (user) {
      userLabel.textContent = user;
      userLabel.style.display = "inline-block";
      loginBtn.style.display = "none";
      logoutBtn.style.display = "inline-block";
    } else {
      userLabel.style.display = "none";
      loginBtn.style.display = "inline-block";
      logoutBtn.style.display = "none";
    }
  }

  updateUI();

  /* =========================
     LIGHTBOX
  ========================= */
  const images = document.querySelectorAll(".media-image");
  const lightbox = document.getElementById("lightbox");
  const lightboxImg = document.getElementById("lightboxImg");

  const closeBtn = document.querySelector(".close");
  const nextBtn = document.querySelector(".next");
  const prevBtn = document.querySelector(".prev");

  let index = 0;

  function openLightbox(i) {
    index = i;
    lightboxImg.src = images[i].src;
    lightbox.classList.add("show");
    lightbox.style.display = "flex";
  }

  function closeLightbox() {
    lightbox.classList.remove("show");
    setTimeout(() => lightbox.style.display = "none", 200);
  }

  function next() {
    index = (index + 1) % images.length;
    openLightbox(index);
  }

  function prev() {
    index = (index - 1 + images.length) % images.length;
    openLightbox(index);
  }

  images.forEach((img, i) => {
    img.addEventListener("click", () => openLightbox(i));
  });

  closeBtn.addEventListener("click", closeLightbox);
  nextBtn.addEventListener("click", next);
  prevBtn.addEventListener("click", prev);

  lightbox.addEventListener("click", (e) => {
    if (e.target === lightbox) closeLightbox();
  });

  document.addEventListener("keydown", (e) => {
    if (lightbox.style.display === "flex") {
      if (e.key === "Escape") closeLightbox();
      if (e.key === "ArrowRight") next();
      if (e.key === "ArrowLeft") prev();
    }
  });

  /* =========================
     MOBILE SWIPE
  ========================= */
  let startX = 0;

  lightbox.addEventListener("touchstart", (e) => {
    startX = e.touches[0].clientX;
  });

  lightbox.addEventListener("touchend", (e) => {
    let endX = e.changedTouches[0].clientX;

    if (startX - endX > 50) next();
    if (endX - startX > 50) prev();
  });

});

/* =========================
   GLOBAL FUNCTIONS
========================= */
function goToLogin() {
  window.location.href = "auth/login.php";
}

function logout() {
  localStorage.removeItem("loggedInUser");
  location.reload();
}

function downloadGame() {
  const a = document.createElement("a");
  a.href = "https://drive.google.com/uc?export=download&id=1j9BSmGxvcAYXP1HQU8TpTc9bL2MV9i-H";
  a.download = "ElementalGenesis.apk";
  a.click();
}






let clickCount = 0;
const logo = document.getElementById("secretLogo");

if (logo) {
  logo.addEventListener("click", () => {
    clickCount++;

    logo.style.transform = "scale(1.1)";
    setTimeout(() => {
      logo.style.transform = "scale(1)";
    }, 100);

    if (clickCount === 5) {
      window.location.href = "secret.php";
    }
  });
}


document.getElementById("secretLogo").addEventListener("click", () => {
  window.scrollTo({
    top: 0,
    behavior: "smooth"
  });
});




</script>

</body>
</html>