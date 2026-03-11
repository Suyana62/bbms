<?php
$conn = mysqli_connect("localhost", "root", "", "blood_db");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$donationQuery = "SELECT donor_name, blood_group, date, quantity_ml, location, email, phone FROM donations ORDER BY date DESC LIMIT 10";
$donationResult = mysqli_query($conn, $donationQuery);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Donation History</title>
    <link rel="stylesheet" type="text/css" href="./public/css/Donationhistory.css">
</head>
<body>
    <a href="index.php" class="home-btn">Home</a>
    <h2>Donation History</h2>
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
        <?php if ($donationResult && mysqli_num_rows($donationResult) > 0) {
            while($row = mysqli_fetch_assoc($donationResult)) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['donor_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['blood_group']); ?></td>
                    <td><?php echo htmlspecialchars($row['date']); ?></td>
                    <td><?php echo htmlspecialchars($row['quantity_ml']); ?></td>
                    <td><?php echo htmlspecialchars($row['location']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td><?php echo htmlspecialchars($row['phone']); ?></td>
                </tr>
        <?php } } else { ?>
            <tr><td colspan="7">No donations found</td></tr>
        <?php } ?>
    </table>
</body>
</html>
<?php mysqli_close($conn); ?>
