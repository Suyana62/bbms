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
  <link rel="stylesheet" type="text/css" href="./public/css/admin_dashboard.css">
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
