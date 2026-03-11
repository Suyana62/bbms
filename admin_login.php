<?php
session_start();
include 'db_connect.php'; // only contains connection

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $sql = "SELECT * FROM admin WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows === 1) {
        $admin = $result->fetch_assoc();

        // ✅ Check password against stored hash
        if (password_verify($password, $admin['password'])) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_username'] = $admin['username'];
            header("Location: admin_dashboard.php");
            exit();
        } else {
            $error = "❌ Incorrect password.";
        }
    } else {
        $error = "❌ Admin user not found.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Blood Bank Management System</title>
  <link rel="stylesheet" type="text/css" href="./public/css/admin_login.css">
</head>
<body>
  <header>
    <a href="index.php" class="home-btn">Home</a>
    <img src="image/logo.png" alt="" 
         style="height:40px; vertical-align:middle; margin-right:10px;">
    <h1 style="display:inline; vertical-align:middle;">Blood Bank Management System</h1>
  </header>

  <main class="container">
    <h2>Admin</h2>
    <form method="post" action="">
      <input type="text" name="username" placeholder="Username" required>
      <input type="password" name="password" placeholder="Password" required>
      <button type="submit">Login</button>
    </form>
    <?php if ($error) echo "<div class='error'>$error</div>"; ?>
  </main>
</body>
</html>
