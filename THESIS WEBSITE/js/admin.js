const table = document.getElementById("userTable");

function loadUsers() {
  let users = JSON.parse(localStorage.getItem("users"));
  table.innerHTML = "";

  users.forEach((user, index) => {

    const isAdmin = user.username === "admin";

    table.innerHTML += `
      <tr>
        <td>
          ${
            isAdmin
              ? `<strong>${user.username}</strong>`
              : `<input value="${user.username}"
                   onchange="updateUser(${index}, 'username', this.value)">`
          }
        </td>

        <td>
          <input value="${user.password}"
            onchange="updateUser(${index}, 'password', this.value)">
        </td>

        <td>
          ${
            isAdmin
              ? `<strong>admin</strong>`
              : `
                <select onchange="updateUser(${index}, 'role', this.value)">
                  <option value="user" ${user.role === "user" ? "selected" : ""}>user</option>
                  <option value="admin" ${user.role === "admin" ? "selected" : ""}>admin</option>
                </select>
              `
          }
        </td>

        <td>${user.loggedIn ? "ONLINE" : "OFFLINE"}</td>

        <td>
          ${
            isAdmin
              ? `<em>Protected</em>`
              : `<button onclick="deleteUser(${index})">Delete</button>`
          }
        </td>
      </tr>
    `;
  });
}

function updateUser(index, key, value) {
  let users = JSON.parse(localStorage.getItem("users"));

  // EXTRA SAFETY CHECK
  if (users[index].username === "admin" && key !== "password") {
    alert("Admin account is protected");
    return;
  }

  users[index][key] = value;
  localStorage.setItem("users", JSON.stringify(users));
}

function deleteUser(index) {
  let users = JSON.parse(localStorage.getItem("users"));

  if (users[index].username === "admin") {
    alert("Admin account cannot be deleted");
    return;
  }

  users.splice(index, 1);
  localStorage.setItem("users", JSON.stringify(users));
  loadUsers();
}

loadUsers();
