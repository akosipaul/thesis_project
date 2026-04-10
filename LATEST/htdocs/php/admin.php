<?php
session_start();

// -----------------------------
// Admin Access Check
// -----------------------------
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit();
}
?>
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
    <button class="logout-btn" id="logoutBtn">Logout</button>
  </div>
</header>

<section class="admin">
  <h2>Users Management</h2>
  <div class="table-wrapper">
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
  </div>
</section>

<script src="../js/admin.js"></script>
<script>
  window.API_PATH = {
    getUsers: "admin_get_users.php",
    updateUser: "admin_update_users.php",
    deleteUser: "admin_delete_users.php",
    logout: "logout.php"
  };
</script>

</body>
</html>