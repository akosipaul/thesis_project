document.addEventListener("DOMContentLoaded", () => {
  const table = document.getElementById("userTable");

  /* ================================
     LOAD USERS
  ================================= */
  async function loadUsers() {
    try {
      const res = await fetch("/elemental-genesis/php/admin_get_users.php");
      const users = await res.json();

      table.innerHTML = ""; // Clear table

      if (!Array.isArray(users)) {
        console.error("Users JSON is invalid:", users);
        return;
      }

      users.forEach(user => {
        const isAdmin = user.username.toLowerCase() === "admin";

        table.innerHTML += `
          <tr>
            <td>
              ${isAdmin
                ? `<strong>${user.username}</strong>`
                : `<input value="${user.username}" onchange="updateUser(${user.id}, 'username', this.value)">`
              }
            </td>
            <td>
              <input value="********" placeholder="Change password" onchange="updateUser(${user.id}, 'password', this.value)">
            </td>
            <td>
              ${isAdmin
                ? `<strong>admin</strong>`
                : `<select onchange="updateUser(${user.id}, 'role', this.value)">
                    <option value="user" ${user.role === "user" ? "selected" : ""}>user</option>
                    <option value="admin" ${user.role === "admin" ? "selected" : ""}>admin</option>
                  </select>`
              }
            </td>
            <td>—</td>
            <td>
              ${isAdmin
                ? `<em>Protected</em>` // Admin cannot be deleted
                : `<button onclick="deleteUser(${user.id}, '${user.username}')">Delete</button>`
              }
            </td>
          </tr>
        `;
      });
    } catch (err) {
      console.error("Failed to load users:", err);
    }
  }

  /* ================================
     UPDATE USER
  ================================= */
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

  /* ================================
     DELETE USER
  ================================= */
  async function deleteUser(id, username) {
    // Protect admin case-insensitively
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
  }

  /* ================================
     LOGOUT
  ================================= */
  window.logout = async function () {
    try {
      const res = await fetch("/elemental-genesis/php/logout.php");
      const data = await res.json();
      if (data.success) {
        window.location.href = "/elemental-genesis/auth/login.php";
      } else {
        alert("Logout failed");
      }
    } catch (err) {
      console.error("Logout failed:", err);
      alert("Server error during logout");
    }
  };

  // Expose functions globally
  window.updateUser = updateUser;
  window.deleteUser = deleteUser;

  loadUsers();
});