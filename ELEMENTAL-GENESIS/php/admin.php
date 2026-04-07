<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Admin Panel</title>
  <link rel="stylesheet" href="../css/admin.css" />
</head>
<body>

<header class="navbar">
  <div class="nav-container">
    <h1 class="logo">ADMIN PANEL</h1>
    <!-- Logout button is now optional -->
    <button class="logout-btn" id="logoutBtn">Logout</button>
  </div>
</header>

<section class="admin">
  <h2>Users Management</h2>
  <table>
    <thead>
      <tr>
        <th>Username</th>
        <th>Password</th>
        <th>Role</th>
        <th>Status</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody id="userTable"></tbody>
  </table>
</section>

<script>
document.addEventListener("DOMContentLoaded", () => {
  const table = document.getElementById("userTable");
  const logoutBtn = document.getElementById("logoutBtn");

  async function loadUsers() {
    try {
      const res = await fetch("/elemental-genesis/php/admin_get_users.php");
      const users = await res.json();

      table.innerHTML = "";

      if (!Array.isArray(users)) {
        console.error("Users JSON is invalid:", users);
        return;
      }

      users.forEach(user => {
        const usernameSafe = user.username.replace(/'/g, "\\'");
        const isAdmin = user.username.toLowerCase() === "admin";

        // Hide logout button if this is the admin account
        if (isAdmin) logoutBtn.style.display = "none";

        // Admin account cannot change role, password, or be deleted
        const deleteButton = isAdmin ? `<em>Protected</em>` : `<button data-id="${user.id}" data-username="${usernameSafe}" class="delete-btn">Delete</button>`;
        const roleSelect = isAdmin 
          ? `<strong>admin</strong>` 
          : `<select data-id="${user.id}" class="role-select">
                <option value="user" ${user.role === "user" ? "selected" : ""}>user</option>
                <option value="admin" ${user.role === "admin" ? "selected" : ""}>admin</option>
            </select>`;

        const passwordInput = isAdmin
          ? `<input value="********" disabled>` // cannot change admin password
          : `<input value="********" placeholder="Change password" data-id="${user.id}" class="password-input">`;

        const usernameInput = isAdmin
          ? `<strong>${user.username}</strong>` // cannot change admin username
          : `<input value="${user.username}" data-id="${user.id}" class="username-input">`;

        table.innerHTML += `
          <tr>
            <td>${usernameInput}</td>
            <td>${passwordInput}</td>
            <td>${roleSelect}</td>
            <td>—</td>
            <td>${deleteButton}</td>
          </tr>
        `;
      });

      // Add delete event listeners
      document.querySelectorAll(".delete-btn").forEach(btn => {
        btn.addEventListener("click", async () => {
          const id = btn.dataset.id;
          const username = btn.dataset.username;
          if (username.toLowerCase() === "admin") {
            alert("❌ Cannot delete admin account!");
            return;
          }
          if (!confirm("Are you sure you want to delete this user?")) return;

          try {
            const res = await fetch("/elemental-genesis/php/admin_delete_users.php", {
              method: "POST",
              headers: { "Content-Type": "application/x-www-form-urlencoded" },
              body: `id=${id}`
            });
            const data = await res.json();
            if (!data.success) alert(data.message);
            loadUsers();
          } catch (err) {
            console.error("Delete failed:", err);
          }
        });
      });

      // Add update listeners for non-admin users
      document.querySelectorAll(".username-input").forEach(input => {
        input.addEventListener("change", () => updateUser(input.dataset.id, 'username', input.value));
      });
      document.querySelectorAll(".password-input").forEach(input => {
        input.addEventListener("change", () => updateUser(input.dataset.id, 'password', input.value));
      });
      document.querySelectorAll(".role-select").forEach(select => {
        select.addEventListener("change", () => updateUser(select.dataset.id, 'role', select.value));
      });

    } catch (err) {
      console.error("Failed to load users:", err);
    }
  }

  async function updateUser(id, key, value) {
    try {
      const res = await fetch("/elemental-genesis/php/admin_update_users.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: `id=${id}&key=${key}&value=${encodeURIComponent(value)}`
      });
      const data = await res.json();
      if (!data.success) alert(data.message);
      loadUsers();
    } catch (err) {
      console.error("Update failed:", err);
    }
  }

  logoutBtn.addEventListener("click", async () => {
    try {
      const res = await fetch("/elemental-genesis/php/logout.php");
      const data = await res.json();
      if (data.success) window.location.href = "/elemental-genesis/auth/login.php";
      else alert("Logout failed");
    } catch (err) {
      console.error("Logout failed:", err);
      alert("Server error during logout");
    }
  });

  loadUsers();
});
</script>

</body>
</html>