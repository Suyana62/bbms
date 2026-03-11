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
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        body {
            background-color: #fff;
            color: #333;
        }

        header {
            background-color: #b30000;
            color: white;
            padding: 20px;
            text-align: center;
            /* Added relative position so the bell can be absolute to this container */
            position: relative; 
        }
        header h1 {
            font-size: 2.5rem;
            letter-spacing: 2px;
        }

        /* --- Updated Notification Styles --- */
        .notify {
            position: absolute;
            right: 30px; /* Moves it to the right */
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            z-index: 2000; /* High z-index to stay above everything */
        }
        .notify img {
            width: 35px;
            filter: brightness(0) invert(1); /* Makes the bell icon white to match header */
        }
        .notify-count {
            position: absolute;
            top: -2px;
            right: -2px;
            background-color: #ffcc00; /* Yellow contrast for visibility */
            color: #000;
            font-size: 11px;
            font-weight: bold;
            border-radius: 50%;
            height: 20px;
            width: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            border: 2px solid #b30000;
        }
        
        .notify-dropdown {
            display: none;
            position: absolute;
            right: 0;
            top: 45px;
            background: white;
            z-index: 2001;
            max-height: 400px;
            overflow-y: auto;
            width: 350px;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
            color: #333;
            text-shadow: none; /* Removes header text shadow */
        }
        /* --- End Notification Styles --- */

        nav {
            background-color: #ff3333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 3rem;
        }
        nav a {
            color: white;
            text-decoration: none;
            margin: 0 20px;
            font-weight: bold;
            transition: 0.3s;
        }
        nav a:hover {
            color: #b30000;
            background-color: #fff;
            padding: 5px 10px;
            border-radius: 5px;
        }
        .user {
            color: white;
            font-size: large;
            margin-left: 20px;
            border-left: 2px solid white;
            padding-left: 15px;
        }

        .hero {
            background: url('image/img5.png') no-repeat center center/cover;
            height: 400px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .container {
            padding: 60px 40px;
            text-align: center;
        }
        .container h3 {
            color: #b30000;
            font-size: 2rem;
            margin-bottom: 20px;
        }

        footer {
            background-color: #b30000;
            color: white;
            text-align: center;
            padding: 20px;
        }

        .notify-dropdown table {
            width: 100%;
            border-collapse: collapse;
        }
        .notify-dropdown table th,
        .notify-dropdown table td {
            padding: 12px;
            border-bottom: 1px solid #eee;
            font-size: 13px;
            text-align: left;
        }
        .notify-dropdown table th {
            background-color: #f8f8f8;
            color: #b30000;
        }
    </style>
</head>
<body>

    <header>
        <h1>Blood Bank Management System</h1>
        <p>Saving Lives Through Blood Donation</p>
            <?php if ( isset($_SESSION['role']) && $_SESSION['role'] == 'requester'): ?>
        <div class="notify" onclick="toggleDropdown()" title="Pending Donors">
            <img src="public/bell.svg" alt="Notification Bell" />
            <?php
            $sql = "SELECT COUNT(donorID) AS total FROM donors WHERE isDonated = 'false'";
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
                            <th>Name</th>
                            <th>Type</th>
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
                            WHERE donors.isDonated = 'false'
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
                            echo "<tr><td colspan='4' style='text-align:center;'>No pending donors</td></tr>";
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
            <?php if ($_SESSION['role'] == 'requester'): ?>
                <a href="request.php">Request Blood</a>
            <?php endif; ?>
        <a href="requesthistory.php">Request History</a>
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

    <script>
        function toggleDropdown() {
            const dropdown = document.getElementById('notifDropdown');
            dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
        }

        // Close dropdown when clicking outside
        window.onclick = function(event) {
            if (!event.target.closest('.notify')) {
                document.getElementById('notifDropdown').style.display = 'none';
            }
        }
    </script>
</body>
</html>