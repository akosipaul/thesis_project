/* ================================
   BASE URL (VERY IMPORTANT)
================================ */
const BASE = "/elemental-genesis";

/* ================================
   SIGNUP
================================ */
async function signup(e) {
  e.preventDefault();

  const username = document.getElementById("signupUsername").value.trim();
  const password = document.getElementById("signupPassword").value.trim();
  const message = document.getElementById("signupMessage");

  try {
    const res = await fetch(`${BASE}/php/signup.php`, {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: `username=${encodeURIComponent(username)}&password=${encodeURIComponent(password)}`
    });

    const data = await res.json();

    message.textContent = data.message;
    message.style.color = data.success ? "green" : "red";

    if (data.success) {
      setTimeout(() => {
        window.location.href = `${BASE}/auth/login.php`;
      }, 1500);
    }

  } catch (error) {
    console.error(error);
    message.textContent = "❌ Something went wrong!";
    message.style.color = "red";
  }
}

/* ================================
   LOGIN
================================ */
async function login(e) {
  e.preventDefault();

  const username = document.getElementById("loginUsername").value;
  const password = document.getElementById("loginPassword").value;

  try {
    const res = await fetch(`${BASE}/php/login.php`, {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: `username=${encodeURIComponent(username)}&password=${encodeURIComponent(password)}`
    });

    const data = await res.json();

    if (!data.success) {
      document.getElementById("loginError").textContent = data.message;
      return;
    }

    if (data.role === "admin") {
      window.location.href = `${BASE}/php/admin.php`;
    } else {
      window.location.href = `${BASE}/index.php`;
    }

  } catch (error) {
    console.error(error);
    document.getElementById("loginError").textContent = "❌ Server error!";
  }
}

/* ================================
   FORGOT PASSWORD
================================ */
async function forgotPassword() {
  const username = prompt("Enter your username");
  if (!username) return;

  const newPass = prompt("Enter new password");
  if (!newPass) return;

  try {
    const res = await fetch(`${BASE}/php/forgot_password.php`, {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: `username=${encodeURIComponent(username)}&password=${encodeURIComponent(newPass)}`
    });

    const data = await res.json();
    alert(data.message);

  } catch (error) {
    console.error(error);
    alert("❌ Error resetting password");
  }
}

/* ================================
   PROTECT PAGES
================================ */
(async function () {
  const page = window.location.pathname;

  // PUBLIC PAGES
  if (
    page.includes("/index.php") ||
    page.includes("/auth/login.php") ||
    page.includes("/auth/signup.php") ||
    page.endsWith("/")
  ) return;

  try {
    const res = await fetch(`${BASE}/php/check_session.php`);
    const data = await res.json();

    if (!data.loggedIn) {
      window.location.href = `${BASE}/auth/login.php`;
      return;
    }

    if (page.includes("/php/admin.php") && data.role !== "admin") {
      window.location.href = `${BASE}/index.php`;
    }

  } catch (err) {
    console.error("Session check failed:", err);
    window.location.href = `${BASE}/auth/login.php`;
  }
})


async function logout() {
  try {
    const res = await fetch(`${BASE}/php/logout.php`);
    const data = await res.json();

    if (data.success) {
      window.location.href = `${BASE}/auth/login.php`;
    } else {
      alert("Logout failed");
    }
  } catch (err) {
    console.error("Logout error:", err);
    alert("Logout error");
  }
};