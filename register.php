<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Connect to database
$conn = mysqli_connect("localhost", "root", "", "blood_db");
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

$register_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = trim($_POST["fullname"]);
    $email    = trim($_POST["email"]);
    $phone    = trim($_POST["phone"]);
    $password = $_POST["password"];
    $bloodID  = $_POST["bloodgroup"]; // VARCHAR(10), so keep as string

    // Hash password securely
    $passwordencrypt = password_hash($password, PASSWORD_DEFAULT);

    // Prepared statement to prevent SQL injection
    $sql  = "INSERT INTO users (fullname, email, phone, password, bloodID)
             VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "sssss", $fullname, $email, $phone, $passwordencrypt, $bloodID);

        if (mysqli_stmt_execute($stmt)) {
            $_SESSION["fullname"] = $fullname;
            header("Location: index.php");
            exit();
        } else {
            $register_message = "Insert failed: " . mysqli_stmt_error($stmt);
        }

        mysqli_stmt_close($stmt);
    } else {
        $register_message = "Prepare failed: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Blood Bank Management System - Register</title>
  <link rel="stylesheet" type="text/css" href="./public/register.css"/>
</head>
<body>
  <div class="login-box">
    <img src="image/logo.png" alt="Blood Bank Logo" class="logo">
    <h2>REGISTER ACCOUNT</h2>
    <p>Fill in your details to join the Blood Bank Management System.</p>

    <?php if (!empty($register_message)) { echo "<p style='color:red;'>$register_message</p>"; } ?>

    <form method="POST" action="">
      <input type="text" name="fullname" id="fullname" placeholder="Full Name" required>
      <input type="email" name="email" id="email" placeholder="Email Address" required>
      <input type="text" name="phone" id="phone" placeholder="Phone Number" required>
      <input type="password" name="password" id="password" placeholder="Password" required>

      <select name="bloodgroup" required>
        <option value="">Select Blood Group</option>
        <option value="A+">A+</option>
        <option value="A-">A-</option>
        <option value="B+">B+</option>
        <option value="B-">B-</option>
        <option value="O+">O+</option>
        <option value="O-">O-</option>
        <option value="AB+">AB+</option>
        <option value="AB-">AB-</option>
      </select>

      <button id="submit" type="submit">Register</button>
    </form>
    <p class="signup">Already have an account? <a href="login.php">Login here</a></p>
  </div>
  <script src="public/register.js" ></script>
</body>
</html>
