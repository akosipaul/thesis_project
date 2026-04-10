document.addEventListener("DOMContentLoaded", () => {
  const table = document.getElementById("userTable");
  const logoutBtn = document.getElementById("logoutBtn");

  // Load all users
  async function loadUsers() {
    try {
      const res = await fetch(window.API_PATH.getUsers);
      const users = await res.json();

      table.innerHTML = "";

      users.forEach(user => {
        const isAdmin = user.role === "admin";

        const usernameCell = isAdmin
          ? `<strong>${user.username}</strong>`
          : `<input value="${user.username}" data-id="${user.id}" class="username-input">`;

        const passwordCell = isAdmin
          ? `<input value="********" disabled>`
          : `<input type="password" placeholder="Change password" data-id="${user.id}" class="password-input">`;

        const roleCell = isAdmin
          ? `<strong>admin</strong>`
          : `<select data-id="${user.id}" class="role-select">
              <option value="user" ${user.role === "user" ? "selected" : ""}>user</option>
              <option value="admin" ${user.role === "admin" ? "selected" : ""}>admin</option>
            </select>`;

        const actionCell = isAdmin
          ? "" // no delete for admin
          : `<button data-id="${user.id}" data-username="${user.username}" class="delete-btn">Delete</button>`;

        table.innerHTML += `
          <tr>
            <td data-label="Username">${usernameCell}</td>
            <td data-label="Password">${passwordCell}</td>
            <td data-label="Role">${roleCell}</td>
            <td data-label="Status">—</td>
            <td data-label="Action">${actionCell}</td>
          </tr>
        `;
      });

      // Event listeners
      document.querySelectorAll(".username-input").forEach(input => {
        input.addEventListener("change", () => updateUser(input.dataset.id, 'username', input.value));
      });

      document.querySelectorAll(".password-input").forEach(input => {
        input.addEventListener("change", () => updateUser(input.dataset.id, 'password', input.value));
      });

      document.querySelectorAll(".role-select").forEach(select => {
        select.addEventListener("change", () => updateUser(select.dataset.id, 'role', select.value));
      });

      document.querySelectorAll(".delete-btn").forEach(btn => {
        btn.addEventListener("click", () => deleteUser(btn.dataset.id, btn.dataset.username));
      });

    } catch (err) {
      console.error("Failed to load users:", err);
    }
  }

  async function updateUser(id, key, value) {
    try {
      const res = await fetch(window.API_PATH.updateUser, {
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

  async function deleteUser(id, username) {
    if (username.toLowerCase() === "admin") {
      alert("❌ Cannot delete admin account!");
      return;
    }
    if (!confirm(`Are you sure you want to delete ${username}?`)) return;

    try {
      const res = await fetch(window.API_PATH.deleteUser, {
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

  logoutBtn.addEventListener("click", async () => {
    try {
      const res = await fetch(window.API_PATH.logout);
      const data = await res.json();
      if (data.success) window.location.href = "../auth/login.php";
      else alert("Logout failed");
    } catch (err) {
      console.error("Logout failed:", err);
    }
  });

  window.updateUser = updateUser;
  window.deleteUser = deleteUser;

  loadUsers();
});