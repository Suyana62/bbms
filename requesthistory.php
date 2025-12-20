<?php
$servername = "localhost";
$username   = "Suyana_Kandel";
$password   = "suyana123";
$dbname     = "blood_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch Request History (include hospital_name and contact_number)
$requestQuery  = "SELECT patient_name, blood_group, date, quantity_ml, hospital_name, contact_number 
                  FROM requests ORDER BY date DESC LIMIT 10";
$requestResult = $conn->query($requestQuery);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Request History</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f7f7f7; padding: 20px; }
        h2 { color: #b30000; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; background: #fff; }
        th, td { padding: 12px; text-align: center; border-bottom: 1px solid #ddd; }
        th { background: #b30000; color: #fff; }
        tr:hover { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2>📝 Request History</h2>
    <table>
        <tr>
            <th>Patient Name</th>
            <th>Blood Group</th>
            <th>Date</th>
            <th>Quantity (ml)</th>
            <th>Hospital Name</th>
            <th>Contact Number</th>
        </tr>
        <?php if ($requestResult && $requestResult->num_rows > 0) {
            while($row = $requestResult->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['patient_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['blood_group']); ?></td>
                    <td><?php echo htmlspecialchars($row['date']); ?></td>
                    <td><?php echo htmlspecialchars($row['quantity_ml']); ?></td>
                    <td><?php echo htmlspecialchars($row['hospital_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['contact_number']); ?></td>
                </tr>
        <?php } } else { ?>
            <tr><td colspan="7">No requests found</td></tr>
        <?php } ?>
    </table>
</body>
</html>
<?php $conn->close(); ?>
