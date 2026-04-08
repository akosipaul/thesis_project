/* ================================
   GET CURRENT USER
================================ */
async function getCurrentUser() {
  try {
    const res = await fetch("../php/check_session.php");
    const data = await res.json();

    if (!data.loggedIn) return null;
    return { username: data.username, role: data.role };
  } catch (err) {
    console.error("Failed to get current user:", err);
    return null;
  }
}

/* ================================
   LOGOUT
================================ */
async function logout() {
  const user = await getCurrentUser();

  if (!user) {
    alert("You are not logged in.");
    return;
  }

  // Call logout endpoint
  try {
    await fetch("../php/logout.php"); // We'll create this
    window.location.href = "/elemental-genesis/index.php";
  } catch (err) {
    console.error("Logout failed:", err);
  }
}