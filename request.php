<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "blood_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $blood_group = $_POST["bloodGroup"];
    $quantity_ml = $_POST["quantity_ml"];
    $userID = $_SESSION["userID"];
    $date = $_POST["date"];
    $sql = "INSERT INTO request(bloodID,userID,reqDate,ml)VALUES('$blood_group','$userID','$date','$quantity_ml')";
    if (mysqli_query($conn, $sql)) {
        header("location: index.php");
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Blood Request</title>
  <link rel="stylesheet" type="text/css" href="./public/css/request.css">
</head>
<body>
  <header>
    <h1>Blood Request Form</h1>
    <nav>
      <!-- Link back to Index page -->
      <a href="index.php">Home</a>
    </nav>
  </header>

  <main class="container">
    <h2>Request Blood</h2>
    <form action="request.php" method="post">
      <label for="bloodGroup">Blood Group:</label>
      <select id="bloodGroup" name="bloodGroup" required>
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

      <label for="quantity">Quantity (ml):</label>
  <input type="number" id="quantity" name="quantity_ml" required>

  <label for="date">Required Date:</label>
      <input type='date' id="date" name="date" min="<?php echo date(
          "Y-m-d",
      ); ?>" required />
  <button type="submit">Submit Request</button>
</form>

  </main>
</body>
</html>
