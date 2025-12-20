<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard</title>
  <style>
    body { font-family: Arial; background: #f4f4f4; margin:0; }
    header { background:#b30000; color:#fff; padding:15px; }
    nav a { color:#fff; margin:0 15px; text-decoration:none; }
    .container { padding:20px; }
    .card { display:inline-block; background:#fff; padding:20px; margin:10px; 
            border-radius:8px; box-shadow:0 2px 6px rgba(0,0,0,0.1); }
  </style>
</head>
<body>
<header>
  <h1>Blood Bank Management System - Admin Dashboard</h1>
  <nav>
    <a href="#">Dashboard</a>
    <a href="#">Donors</a>
    <a href="#">Requests</a>
    <a href="#">Inventory</a>
    <a href="#">Reports</a>
    <a href="logout.php">Logout</a>
  </nav>
</header>

<div class="container">
  <h2>Welcome, <?php echo $_SESSION['admin_username']; ?> 👋</h2>
  
  <div class="card">Total Donors:5 </div>
  <div class="card">Total Requests:6</div>
  <div class="card">Available Units: 700</div>
  <div class="card">Pending Approvals: pending </div>
</div>
</body>
</html>
