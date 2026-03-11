<?php
$conn = mysqli_connect("localhost", "root", "", "blood_db");
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_req_id'])) {
    $deleteID = mysqli_real_escape_string($conn, $_POST['delete_req_id']);
    // Delete child donors rows first to satisfy the FK constraint
    mysqli_query($conn, "DELETE FROM donors WHERE reqID = '$deleteID'");
    mysqli_query($conn, "DELETE FROM request WHERE reqID = '$deleteID'");
    header("Location: admin_dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard</title>
  <link rel="stylesheet" type="text/css" href="./public/css/admin_dashboard.css">
</head>
<body>
<header>
  <h1>Blood Bank Management System - Admin Dashboard</h1>
  <nav>
    <a href="#">Donors</a>
    <a href="#">Requests</a>
    <a href="logout.php">Logout</a>
  </nav>
</header>

<div class="container">
  <h2>Welcome, <?php echo $_SESSION['admin_username']; ?> 👋</h2>
  
  <div class="card">Total Donors:5 </div>
  <div class="card">Total Requests:6</div>
  <div class="card">Available Units: 700</div>
  <div class="card">Pending Approvals: pending </div>
<h1>Active requests</h1>
  <table>
<tr><th>name</td>
<th>bloodtype</td>
<th>req date</td>
<th>ml quantity</td>
<th>phone</td>
<th>action</th>
</tr>
  <?php 
      // Active requests: exclude any reqID that has isDonated = 1 in donors
      $requestQuery = "SELECT request.reqID, blood.bloodType, users.FullName, request.reqDate, request.ml, users.phone 
                     FROM request 
                     JOIN users ON users.userID = request.userID 
                     JOIN blood ON request.bloodID = blood.bloodID
                     WHERE request.reqID NOT IN (
                         SELECT reqID FROM donors WHERE isDonated = 1
                     )";
      $requestResult = mysqli_query($conn, $requestQuery);
      if (mysqli_num_rows($requestResult) == 0) { ?>
          <tr><td colspan="6" style="text-align:center;">No active requests.</td></tr>
      <?php } else {
          while($row = mysqli_fetch_assoc($requestResult)) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['FullName']); ?></td>
                    <td><?php echo htmlspecialchars($row['bloodType']); ?></td>
                    <td><?php echo htmlspecialchars($row['reqDate']); ?></td>
                    <td><?php echo htmlspecialchars($row['ml']); ?></td>
                    <td><?php echo htmlspecialchars($row['phone']); ?></td>
                    <td>
                        <a href="edit_request.php?id=<?php echo $row['reqID']; ?>" class="action-btn">Edit</a>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="delete_req_id" value="<?php echo $row['reqID']; ?>">
                            <button type="submit" class="delete-btn" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
      <?php } } ?>
  </table>

  <h1>Fulfilled / Donated Requests</h1>
  <table>
    <tr>
      <th>Requester</th>
      <th>Blood Type</th>
      <th>Req Date</th>
      <th>Quantity (ml)</th>
      <th>Donor</th>
      <th>Phone</th>
    </tr>
    <?php
      $fulfilledQuery = "SELECT request.reqID, blood.bloodType, users.FullName AS requester, 
                                request.reqDate, request.ml, users.phone,
                                donor_user.FullName AS donorName
                         FROM donors
                         JOIN request ON donors.reqID = request.reqID
                         JOIN blood ON request.bloodID = blood.bloodID
                         JOIN users ON users.userID = request.userID
                         LEFT JOIN users AS donor_user ON donor_user.userID = donors.userID
                         WHERE donors.isDonated = 1";
      $fulfilledResult = mysqli_query($conn, $fulfilledQuery);
      if (mysqli_num_rows($fulfilledResult) == 0) { ?>
          <tr><td colspan="6" style="text-align:center;">No fulfilled requests yet.</td></tr>
      <?php } else {
          while ($frow = mysqli_fetch_assoc($fulfilledResult)) { ?>
          <tr>
              <td><?php echo htmlspecialchars($frow['requester']); ?></td>
              <td><?php echo htmlspecialchars($frow['bloodType']); ?></td>
              <td><?php echo htmlspecialchars($frow['reqDate']); ?></td>
              <td><?php echo htmlspecialchars($frow['ml']); ?></td>
              <td><?php echo htmlspecialchars($frow['donorName'] ?? 'N/A'); ?></td>
              <td><?php echo htmlspecialchars($frow['phone']); ?></td>
          </tr>
      <?php } } ?>
  </table>
</div>
</body>
</html>
