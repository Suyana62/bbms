<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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
    $status         = "Pending";

    $sql = "INSERT INTO requests (patient_name, blood_group, quantity_ml, hospital_name, contact_number, date, status) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssissss", $patient_name, $blood_group, $quantity_ml, $hospital_name, $contact_number, $date, $status);

    if ($stmt->execute()) {
        echo "✅ Request submitted successfully!";
    } else {
        echo "❌ Error: " . $stmt->error;
    }
}
?>
