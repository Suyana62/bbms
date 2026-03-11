<?php
$servername = "localhost";
$username   = "Suyana_Kandel";
$password   = "suyana123";
$dbname     = "blood_db";
session_start();
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch Request History (include hospital_name and contact_number)
$requestQuery="SELECT blood.bloodType, users.FullName,request.reqDate, request.ml, users.phone FROM request LEFT JOIN donors ON request.reqID = donors.reqID JOIN users ON users.userID = request.userID JOIN blood ON request.bloodID = blood.bloodID WHERE donors.reqID IS NULL;";
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
        button{
            margin-left: 1rem;
        }
    </style>
</head>
<body>
    <h2>📝 Request History</h2>
    <table>
        <tr>
            <th>Requester</th>
            <th>Blood Group</th>
            <th>Date</th>
            <th>Quantity (ml)</th>
            <th>Contact Number</th>
            <th>action</th>
        </tr>
        <?php if ($requestResult && $requestResult->num_rows > 0) {
            while($row = $requestResult->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['FullName']); ?></td>
                    <td><?php echo htmlspecialchars($row['bloodType']); ?></td>
                    <td><?php echo htmlspecialchars($row['reqDate']); ?></td>
                    <td><?php echo htmlspecialchars($row['ml']); ?></td>
                    <td><?php echo htmlspecialchars($row['phone']); ?></td>
                    <?php if($_SESSION['role']=='donor'){ ?>
                    <td><button>Donate</button></td>
                    <?php } else{?>
                    <td><button>Edit</button><button>Delete</button></td>
                    <?php } ?>
                </tr>
        <?php } } else { ?>
            <tr><td colspan="7">No requests found</td></tr>
        <?php } ?>
    </table>
</body>
</html>
<?php $conn->close(); ?>
