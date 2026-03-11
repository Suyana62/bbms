<?php
$conn = mysqli_connect("localhost", "root", "", "blood_db");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['donate_req_id'])) {
    $reqID = $_POST['donate_req_id'];
    $userID = $_SESSION['userID'];
    
    $insertSql = "INSERT INTO donors (userID, reqID, isDonated) VALUES ('$userID', '$reqID', 0)";
    if (mysqli_query($conn, $insertSql)) {
        header("Location: requests.php");
        exit();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_req_id'])) {
    $reqID = $_POST['delete_req_id'];
    $deleteSql = "DELETE FROM request WHERE reqID = '$reqID'";
    if (mysqli_query($conn, $deleteSql)) {
        header("Location: requests.php");
        exit();
    }
}

$userID = isset($_SESSION['userID']) ? $_SESSION['userID'] : null;
$role = isset($_SESSION['role']) ? $_SESSION['role'] : null;

if ($role == 'donor') {
    $requestQuery = "SELECT request.reqID, request.userID, blood.bloodType, users.FullName, request.reqDate, request.ml, users.phone 
                     FROM request 
                     LEFT JOIN donors ON request.reqID = donors.reqID 
                     JOIN users ON users.userID = request.userID 
                     JOIN blood ON request.bloodID = blood.bloodID 
                     WHERE donors.reqID IS NULL";
} else {
    $requestQuery = "SELECT request.reqID, request.userID, blood.bloodType, users.FullName, request.reqDate, request.ml, users.phone 
                     FROM request 
                     LEFT JOIN donors ON request.reqID = donors.reqID 
                     JOIN users ON users.userID = request.userID 
                     JOIN blood ON request.bloodID = blood.bloodID 
                     WHERE request.userID = '$userID' AND donors.reqID IS NULL";
}
$requestResult = mysqli_query($conn, $requestQuery);

if ($role == 'donor') {
    $acceptedQuery = "SELECT request.reqID, request.userID, blood.bloodType, users.FullName as requesterName, users.phone as requesterPhone, 
                       request.reqDate, request.ml, donors.isDonated,
                       donors.userID as donorUserID, donor_user.FullName as donorName, donor_user.phone as donorPhone
                       FROM request 
                       INNER JOIN donors ON request.reqID = donors.reqID 
                       JOIN users ON users.userID = request.userID 
                       JOIN blood ON request.bloodID = blood.bloodID
                       JOIN users as donor_user ON donor_user.userID = donors.userID
                       WHERE donors.userID = '$userID'";
} else {
    $acceptedQuery = "SELECT request.reqID, request.userID, blood.bloodType, users.FullName, request.reqDate, request.ml, donors.isDonated,
                       donor_user.FullName as donorName, donor_user.phone as donorPhone
                       FROM request 
                       INNER JOIN donors ON request.reqID = donors.reqID 
                       JOIN users ON users.userID = request.userID 
                       JOIN blood ON request.bloodID = blood.bloodID
                       JOIN users as donor_user ON donor_user.userID = donors.userID
                       WHERE request.userID = '$userID'";
}
$acceptedResult = mysqli_query($conn, $acceptedQuery);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Request History</title>
    <link rel="stylesheet" type="text/css" href="./public/css/requests.css">
</head>
<body>
    <a href="index.php" class="home-btn">Home</a>
    <h2>Requests</h2>
    <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'requester'): ?>
    <a href="request.php" class="request-btn">Request Blood</a>
    <?php endif; ?>
    <h3 style="margin-top: 30px; color: #b30000;">Pending Requests</h3>
    <table>
        <tr>
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'donor'): ?>
            <th>Requester</th>
            <?php endif; ?>
            <th>Blood Group</th>
            <th>Date</th>
            <th>Quantity (ml)</th>
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'donor'): ?>
            <th>Contact Number</th>
            <?php endif; ?>
            <th>action</th>
        </tr>
        <?php if ($requestResult && mysqli_num_rows($requestResult) > 0) {
            while($row = mysqli_fetch_assoc($requestResult)) { ?>
                <tr>
                    <?php if ($_SESSION['role'] == 'donor'): ?>
                    <td><?php echo htmlspecialchars($row['FullName']); ?></td>
                    <?php endif; ?>
                    <td><?php echo htmlspecialchars($row['bloodType']); ?></td>
                    <td><?php echo htmlspecialchars($row['reqDate']); ?></td>
                    <td><?php echo htmlspecialchars($row['ml']); ?></td>
                    <?php if ($_SESSION['role'] == 'donor'): ?>
                    <td><?php echo htmlspecialchars($row['phone']); ?></td>
                    <?php endif; ?>
                    <?php if($_SESSION['role']=='donor'){ ?>
                    <td>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="donate_req_id" value="<?php echo $row['reqID']; ?>">
                            <button type="submit">Donate</button>
                        </form>
                    </td>
                    <?php } elseif($_SESSION['userID'] == $row['userID']) { ?>
                    <td>
                        <a href="edit_request.php?id=<?php echo $row['reqID']; ?>" class="action-btn">Edit</a>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="delete_req_id" value="<?php echo $row['reqID']; ?>">
                            <button type="submit" class="delete-btn" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                    <?php } else { ?>
                    <td>-</td>
                    <?php } ?>
                </tr>
        <?php } } else { ?>
            <tr><td colspan="<?php echo ($role == 'donor') ? 6 : 4; ?>">No pending requests</td></tr>
        <?php } ?>
    </table>

    <h3 style="margin-top: 30px; color: #b30000;">Accepted/Donated Requests</h3>
    <table>
        <tr>
            <th>Blood Group</th>
            <th>Date</th>
            <th>Quantity (ml)</th>
            <th>Status</th>
            <th>Details</th>
        </tr>
        <?php if ($acceptedResult && mysqli_num_rows($acceptedResult) > 0) {
            while($row = mysqli_fetch_assoc($acceptedResult)) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['bloodType']); ?></td>
                    <td><?php echo htmlspecialchars($row['reqDate']); ?></td>
                    <td><?php echo htmlspecialchars($row['ml']); ?></td>
                    <td>
                        <?php if ($row['isDonated'] == 1): ?>
                            <span style="color: green; font-weight: bold;">Donated</span>
                        <?php else: ?>
                            <span style="color: orange; font-weight: bold;">Accepted</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <button class="expand-btn" id="btn-<?php echo $row['reqID']; ?>" onclick="toggleDetails(<?php echo $row['reqID']; ?>)">View</button>
                    </td>
                </tr>
                <tr id="details-<?php echo $row['reqID']; ?>" class="details-row">
                    <td colspan="5">
                        <div class="details-content">
                            <div class="donor-info">
                            <h4>Donor Information</h4>
                            <p><strong>Name:</strong> <?php echo htmlspecialchars($row['donorName']); ?></p>
                            <p><strong>Phone:</strong> <?php echo htmlspecialchars($row['donorPhone']); ?></p>
                            <?php if ($role == 'donor'): ?>
                            <p><strong>Requester:</strong> <?php echo htmlspecialchars($row['requesterName']); ?></p>
                            <p><strong>Requester Phone:</strong> <?php echo htmlspecialchars($row['requesterPhone']); ?></p>
                            <?php endif; ?>
                        </div>
                        </div>
                    </td>
                </tr>
        <?php } } else { ?>
            <tr><td colspan="5">No accepted requests</td></tr>
        <?php } ?>
    </table>

    <script>
    function toggleDetails(id) {
        var row = document.getElementById('details-' + id);
        var btn = document.getElementById('btn-' + id);
        row.classList.toggle('open');
        if (row.classList.contains('open')) {
            btn.textContent = 'Hide';
        } else {
            btn.textContent = 'View';
        }
    }
    </script>
</body>
</html>
<?php mysqli_close($conn); ?>
