/* ================================
   INITIALIZE USERS (RUN ONCE)
================================ */
// FORCE ADMIN ACCOUNT TO EXIST
let users = JSON.parse(localStorage.getItem("users")) || [];

const adminExists = users.some(u => u.username === "admin");

if (!adminExists) {
  users.push({
    username: "admin",
    password: "admin123",
    role: "admin",
    loggedIn: false
  });
}

localStorage.setItem("users", JSON.stringify(users));


/* ================================
   SIGNUP
================================ */
function signup(e) {
  e.preventDefault();

  const username = document.getElementById("signupUsername").value;
  const password = document.getElementById("signupPassword").value;

  let users = JSON.parse(localStorage.getItem("users"));

  if (users.find(u => u.username === username)) {
    alert("Username already exists");
    return;
  }

  users.push({
    username,
    password,
    role: "user",
    loggedIn: false
  });

  localStorage.setItem("users", JSON.stringify(users));

  alert("Account created! Please login.");
  window.location.href = "login.html";
}

/* ================================
   LOGIN
================================ */
function login(e) {
  e.preventDefault();

  const username = document.getElementById("loginUsername").value;
  const password = document.getElementById("loginPassword").value;

  let users = JSON.parse(localStorage.getItem("users"));

  const user = users.find(
    u => u.username === username && u.password === password
  );

  if (!user) {
    alert("Invalid username or password");
    return;
  }

  // Log out everyone first
  users.forEach(u => u.loggedIn = false);

  user.loggedIn = true;

  localStorage.setItem("users", JSON.stringify(users));
  localStorage.setItem("loggedInUser", user.username);

  if (user.role === "admin") {
    window.location.href = "admin.html";
  } else {
    window.location.href = "index.html";
  }
}

/* ================================
   FORGOT PASSWORD
================================ */
function forgotPassword() {
  const username = prompt("Enter your username");
  if (!username) return;

  let users = JSON.parse(localStorage.getItem("users"));
  const user = users.find(u => u.username === username);

  if (!user) {
    alert("User not found");
    return;
  }

  const newPass = prompt("Enter new password");
  if (!newPass) return;

  user.password = newPass;
  localStorage.setItem("users", JSON.stringify(users));
  alert("Password updated!");
}

/* ================================
   PROTECT PAGES
================================ */
(function protectPages() {
  const page = window.location.pathname;
  const currentUser = localStorage.getItem("loggedInUser");
  const users = JSON.parse(localStorage.getItem("users")) || [];

  (function protectPages() {
    const page = window.location.pathname;
    const currentUser = localStorage.getItem("loggedInUser");
    const users = JSON.parse(localStorage.getItem("users")) || [];

  // PUBLIC PAGES (NO LOGIN REQUIRED)
    if (
      page.includes("index.html") ||
      page === "/" ||
      page.includes("login.html") ||
      page.includes("signup.html")
    ) {
      return;
    }

  // BLOCK OTHER PAGES IF NOT LOGGED IN
    if (!currentUser) {
      window.location.href = "login.html";
      return;
    }

  const user = users.find(u => u.username === currentUser);

  // ADMIN PROTECTION
    if (page.includes("admin.html") && user?.role !== "admin") {
      window.location.href = "index.html";
    }
  })();


  const user = users.find(u => u.username === currentUser);

  if (page.includes("admin.html") && user?.role !== "admin") {
    window.location.href = "index.html";
  }
})();
