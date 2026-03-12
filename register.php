<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

// Connect to database
$conn = mysqli_connect("localhost", "root", "", "blood_db");
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

$register_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = trim($_POST["fullname"]);
    $email = trim($_POST["email"]);
    $phone = trim($_POST["phone"]);
    $password = $_POST["password"];
    $bloodID = !empty($_POST["bloodgroup"]) ? $_POST["bloodgroup"] : NULL;
    $role = $_POST["role"];

    // Hash password securely
    $passwordencrypt = password_hash($password, PASSWORD_DEFAULT);

    // Prepared statement to prevent SQL injection
    $sql = "INSERT INTO users (fullName, email, phone, password, bloodID, role)
             VALUES ('$fullname', '$email', '$phone', '$passwordencrypt', '$bloodID', '$role')";
    if (mysqli_query($conn, $sql)) {
        $_SESSION["fullname"] = $fullname;
        $_SESSION["role"] = $role;
        $_SESSION["userID"] = mysqli_insert_id($conn);
        header("location: index.php");
        exit();
    } else {
        $register_message = "Error: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Blood Bank Management System - Register</title>
  <link rel="stylesheet" type="text/css" href="./public/register.css"/>
</head>
<body>
  <a href="index.php" class="home-btn">Home</a>
  <div class="login-box">
    <img src="image/logo.png" alt="Blood Bank Logo" class="logo">
    <h2>REGISTER ACCOUNT</h2>
    <p>Fill in your details to join the Blood Bank Management System.</p>

    <?php if (!empty($register_message)) {
        echo "<p style='color:red;'>$register_message</p>";
    } ?>

    <form method="POST" action="">
        <p class="error" id="errorFullName" ></p>
      <input type="text" name="fullname" id="fullname" placeholder="Full Name" required>
      <p class="error" id="errorEmail" ></p>
      <input type="email" name="email" id="email" placeholder="Email Address" required>
      <select name="role" id="role">
        <option value="requester">requester</option>
        <option value="donor">donor</option>
      </select>
      <p class="error" id="errorPhone" ></p>
      <input type="text" name="phone" id="phone" placeholder="Phone Number" required>
      <p class="error" id="errorPassword" ></p>
      <div class="password-wrapper">
          <input type="password" name="password" id="password" placeholder="Password" required>
                 <span onclick="togglePassword()" class="toggle-eye">👁️</span>
      </div>
      <div class="password-wrapper">
          <input type="password" name="confirmPassword" id="confirmPassword" placeholder="Password" required>
            <span onclick="togglePassword()" class="toggle-eye">👁️</span>
            </div>

      <select name="bloodgroup" required>
        <option value="">Select Blood Group</option>
        <?php
        $sql = "SELECT * FROM blood";
        $result = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_assoc($result)) { ?>
        <option value="<?php echo $row["bloodID"]; ?>"><?php echo $row[
    "bloodType"
]; ?></option>
        <?php }
        ?>
      </select>

      <button id="submit" type="submit">Register</button>
    </form>
    <p class="signup">Already have an account? <a href="login.php">Login here</a></p>
  </div>
  <script src="public/register.js" ></script>
</body>
</html>
