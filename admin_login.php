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
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f9f9f9;
      margin: 0;
      padding: 0;
    }
    header {
      background: #b30000; /* blood red */
      color: #fff;
      padding: 15px;
      text-align: center;
    }
    header h1 {
      margin: 0;
    }
    .container {
      width: 80%;
      max-width: 400px;
      margin: 40px auto;
      background: #fff;
      padding: 25px;
      border-radius: 8px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }
    h2 {
      text-align: center;
      color: #b30000;
    }
    form input {
      width: 100%;
      padding: 10px;
      margin-top: 12px;
      border: 1px solid #ccc;
      border-radius: 4px;
    }
    form input:focus {
      border: 1px solid #b30000;
      outline: none;
    }
    form button {
      margin-top: 20px;
      background: #b30000;
      color: #fff;
      padding: 12px 18px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      font-size: 15px;
      font-weight: bold;
      width: 100%;
    }
    form button:hover {
      background: #800000;
    }
    .error {
      color: red;
      text-align: center;
      margin-top: 10px;
    }
  </style>
</head>
<body>
  <header>
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
