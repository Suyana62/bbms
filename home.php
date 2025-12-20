<?php
session_start();
if (!isset($_SESSION["fullname"])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Blood Bank - Home</title>
</head>
<body>
    <h2>Welcome, <?php echo $_SESSION["fullname"]; ?>!</h2>
    <p>You are logged in to the Blood Bank Management System.</p>
    <a href="logout.php">Logout</a>
</body>
</html>
