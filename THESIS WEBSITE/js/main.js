function getCurrentUser() {
  const username = localStorage.getItem("loggedInUser");
  if (!username) return null;

  const users = JSON.parse(localStorage.getItem("users")) || [];
  return users.find(u => u.username === username);
}

/* LOGOUT */
function logout() {
  const user = getCurrentUser();

  if (!user) {
    alert("You are not logged in.");
    return;
  }

  let users = JSON.parse(localStorage.getItem("users"));

  users.forEach(u => {
    if (u.username === user.username) {
      u.loggedIn = false;
    }
  });

  localStorage.setItem("users", JSON.stringify(users));
  localStorage.removeItem("loggedInUser");

  window.location.href = "index.html";
}



