<?php
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "blood_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $patient_name   = $_POST['patientName'];
    $blood_group    = $_POST['bloodGroup'];
    $quantity_ml    = $_POST['quantity_ml'];
    $hospital_name  = $_POST['hospital'];
    $contact_number = $_POST['contact'];
    $date           = $_POST['date'];
    $sql = "INSERT INTO requests (patient_name, blood_group, quantity_ml, hospital_name, contact_number, date,) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssissss", $patient_name, $blood_group, $quantity_ml, $hospital_name, $contact_number, $date, );

    if ($stmt->execute()) {
    header("Location: requesthistory.php");
    exit();
} else {
    die("Insert failed: " . $stmt->error);
}

}
$conn->close();
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
      <label for="patientName">Patient Name:</label>
      <input type="text" id="patientName" name="patientName" required>

      <label for="bloodGroup">Blood Group:</label>
      <select id="bloodGroup" name="bloodGroup" required>
        <option value="">--Select--</option>
        <option value="A+">A+</option>
        <option value="A-">A-</option>
        <option value="B+">B+</option>
        <option value="B-">B-</option>
        <option value="O+">O+</option>
        <option value="O-">O-</option>
        <option value="AB+">AB+</option>
        <option value="AB-">AB-</option>
      </select>

      <label for="quantity">Quantity (ml):</label>
  <input type="number" id="quantity" name="quantity_ml" required>

  <label for="hospital">Hospital Name:</label>
  <input type="text" id="hospital" name="hospital" required>

  <label for="contact">Contact Number:</label>
  <input type="tel" id="contact" name="contact" required>

  <label for="date">Required Date:</label>
  <input type="date" id="date" name="date" required>

  <button type="submit">Submit Request</button>
</form>

  </main>
</body>
</html>
