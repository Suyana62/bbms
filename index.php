<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "blood_db");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Blood Bank Management System</title>
    <link rel="stylesheet" type="text/css" href="./public/css/index.css">
</head>
<body>

    <header>
        <h1>Blood Bank Management System</h1>
        <p>Saving Lives Through Blood Donation</p>
            <?php if ( isset($_SESSION['role']) && $_SESSION['role'] == 'requester'): ?>
        <div class="notify" onclick="toggleDropdown()" title="Notifications">
            <img src="public/bell.svg" alt="Notification Bell" />
            <?php
            $userID = $_SESSION['userID'];
            $sql = "SELECT COUNT(donorID) AS total FROM donors 
                    JOIN request ON request.reqID = donors.reqID 
                    WHERE request.userID = '$userID' AND donors.isDonated = 'false'";
            $res = mysqli_query($conn, $sql);
            $result = mysqli_fetch_assoc($res);
            if ($result["total"] > 0) {
                echo '<div class="notify-count">' . $result["total"] . '</div>';
            }
            ?>
            <div class="notify-dropdown" id="notifDropdown">
                <table>
                    <thead>
                        <tr>
                            <th>Donor Name</th>
                            <th>Blood Type</th>
                            <th>Phone</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sqlDonors = "
                            SELECT users.FullName, blood.bloodType, users.phone, request.reqDate
                            FROM donors
                            JOIN users ON users.userID = donors.userID
                            JOIN request ON request.reqID = donors.reqID
                            JOIN blood ON blood.bloodID = request.bloodID
                            WHERE request.userID = '$userID' AND donors.isDonated = 'false'
                            ORDER BY request.reqDate DESC
                            LIMIT 10
                        ";
                        $donorResult = mysqli_query($conn, $sqlDonors);

                        if (mysqli_num_rows($donorResult) > 0) {
                            while ($donor = mysqli_fetch_assoc($donorResult)) {
                                echo "<tr>
                                        <td>" . htmlspecialchars($donor['FullName']) . "</td>
                                        <td>" . htmlspecialchars($donor['bloodType']) . "</td>
                                        <td>" . htmlspecialchars($donor['phone']) . "</td>
                                        <td>" . htmlspecialchars($donor['reqDate']) . "</td>
                                      </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='4' style='text-align:center;'>No new notifications</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php endif ?>
    </header>

    <nav>
        <?php if (isset($_SESSION['role'])): ?>
        <a href="requests.php">Requests</a>
        <?php endif; ?>
        <a href="Contact.php">Contact</a>
        <?php if (isset($_SESSION['fullname'])): ?>
            <strong class="user"><?= htmlspecialchars($_SESSION['fullname']); ?></strong>
            <a href="logout.php">Logout</a>
        <?php else: ?>
            <a href="login.php" style="background: white; color: #b30000; padding: 5px 15px; border-radius: 4px;">Login</a>
        <?php endif; ?>
    </nav>

    <section class="hero"></section>

    <div class="container">
        <h3>Welcome to Our Blood Bank Management System</h3>
        <p>Our mission is to show the timely available blood here you can see the details of donors, hospitals, and patients.</p>
    </div>

    <footer>
        <p>&copy; 2025 Blood Bank Management System | Designed by Suyana and Kriti</p>
    </footer>

    <script src="./public/js/index.js"></script>
</body>
</html>