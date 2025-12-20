<?php
$conn = mysqli_connect("localhost","root","","blood_db");
session_start();
$login_error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];
    $passwordencrypt = md5($password);
    $query = "SELECT fullname FROM users where email = '$email' AND password ='$passwordencrypt'";
    $result = mysqli_query($conn, $query);

  if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_array($result);
    $_SESSION["fullname"]= $row["fullname"];
    header("location: index.php");
  }
  else{
    $login_error = "Invalid username or password";
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Blood Bank Management System - Login</title>
  <link rel="stylesheet" type="text/css" href="./public/login.css">
</head>
<body>
  <div class="login-box">
    <img src="image/logo.png" alt="Blood Bank Logo" class="logo">
    <h2>BLOOD BANK MANAGEMENT SYSTEM</h2>
    <p>Welcome! Please log in to manage donors, recipients, and blood inventory.</p>

    <?php echo $login_error; ?>

    <form method="POST" action="">
      <input type="text" name="email" placeholder="Email" required>
      <div class="password-wrapper">
        <input type="password" name="password" id="password" placeholder="Password" required>
        <span onclick="togglePassword()" class="toggle-eye">👁️</span>
      </div>
      
      <a href="#" class="forgot">Forgot Password?</a>
      <button type="submit">Sign In</button>
    </form>
    <p class="signup">New staff? <a href="register.php">Create Account</a></p>
  </div>

  <script>
    function togglePassword() {
      const pwd = document.getElementById("password");
      pwd.type = pwd.type === "password" ? "text" : "password";
    }
  </script>
</body>
</html>