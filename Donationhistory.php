<?php
// db_connect.php
$servername = "localhost";
$username   = "Suyana_Kandel";   
$password   = "suyana123";
$dbname     = "blood_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch Donation History
$donationQuery  = "SELECT donor_name, blood_group, date, quantity_ml,location,email,phone FROM donations ORDER BY date DESC LIMIT 10";
$donationResult = $conn->query($donationQuery);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Donation History</title>
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
    <h2>💉 Donation History</h2>
    <table>
        <tr>
            <th>Donor Name</th>
            <th>Blood Group</th>
            <th>Date</th>
            <th>Quantity</th>
            <th>location</th>
            <th>email</th>
            <th>phone</th>
        </tr>
        <?php if ($donationResult->num_rows > 0) {
            while($row = $donationResult->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['donor_name']; ?></td>
                    <td><?php echo $row['blood_group']; ?></td>
                    <td><?php echo $row['date']; ?></td>
                    <td><?php echo $row['quantity_ml']; ?></td>
                     <td><?php echo $row['location']; ?></td>
                      <td><?php echo $row['email']; ?></td>
                       <td><?php echo $row['phone']; ?></td>
                </tr>
        <?php } } else { ?>
            <tr><td colspan="4">No donations found</td></tr>
        <?php } ?>
    </table><?php
// db_connect.php
$servername = "localhost";
$username   = "Suyana_Kandel";   
$password   = "suyana123";
$dbname     = "blood_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch Donation History (added hospital_name and contact_number)
$donationQuery  = "SELECT donor_name, blood_group, date, quantity_ml, location, email, phone
                   FROM donations 
                   ORDER BY date DESC 
                   LIMIT 10";
$donationResult = $conn->query($donationQuery);