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
  <style>
    /* General reset */
    body, h1, h2, p, form {
      margin: 0;
      padding: 0;
      font-family: Arial, sans-serif;
    }

    body {
      background: #f9f9f9;
      color: #333;
    }

    /* Header styling */
    header {
      background: #b30000; /* blood red */
      color: #fff;
      padding: 15px;
      text-align: center;
    }

    header h1 {
      margin-bottom: 10px;
    }

    nav a {
      color: #fff;
      margin: 0 10px;
      text-decoration: none;
      font-weight: bold;
    }

    nav a:hover {
      text-decoration: underline;
    }

    /* Container styling */
    .container {
      width: 80%;
      max-width: 600px;
      margin: 30px auto;
      background: #fff;
      padding: 25px;
      border-radius: 8px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }

    /* Form styling */
    form label {
      display: block;
      margin-top: 12px;
      font-weight: bold;
      color: #444;
    }

    form input, form select {
      width: 100%;
      padding: 10px;
      margin-top: 6px;
      border: 1px solid #ccc;
      border-radius: 4px;
      transition: border 0.3s ease;
    }

    form input:focus, form select:focus {
      border: 1px solid #b30000;
      outline: none;
    }

    /* Button styling */
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
      transition: background 0.3s ease;
    }

    form button:hover {
      background: #800000;
    }
  </style>
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
    <form action="Request.php" method="post">
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
  <input type="date" id="date" name="date" required>

  <button type="submit">Submit Request</button>
</form>

  </main>
</body>
</html>
