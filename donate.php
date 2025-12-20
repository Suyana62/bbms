<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "blood_db");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['submit'])) {
    $fullname       = mysqli_real_escape_string($conn, $_POST["fullname"]);
    $email          = mysqli_real_escape_string($conn, $_POST["email"]);
    $phone          = mysqli_real_escape_string($conn, $_POST["phone"]);
    $bloodgroup     = mysqli_real_escape_string($conn, $_POST["bloodgroup"]);
    $donation_date  = mysqli_real_escape_string($conn, $_POST["donation_date"]);
    $quantity_ml    = mysqli_real_escape_string($conn, $_POST["quantity_ml"]);
    $location       = mysqli_real_escape_string($conn, $_POST["location"]);

    // Insert into donations table
    $sql = "INSERT INTO donations (donor_name, email, phone, blood_group, date, quantity_ml, location)
            VALUES ('$fullname', '$email', '$phone', '$bloodgroup', '$donation_date', '$quantity_ml', '$location')";

    if (mysqli_query($conn, $sql)) {
        // Redirect to index.php after successful donation
        header("Location: index.php");
        exit();
    } else {
        echo "❌ Error: " . mysqli_error($conn);
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Donate Blood - Blood Bank</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .donate-box {
            background: #fff;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            width: 350px;
        }
        .donate-box h2 {
            text-align: center;
            color: #b30000;
            margin-bottom: 20px;
        }
        .donate-box form {
            display: flex;
            flex-direction: column;
        }
        .donate-box label {
            margin-bottom: 10px;
            font-weight: bold;
            color: #333;
        }
        .donate-box input, .donate-box select {
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .donate-box button {
            margin-top: 15px;
            padding: 12px;
            background: #b30000;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
        }
        .donate-box button:hover {
            background: #800000;
        }
    </style>
</head>
<body>
    <div class="donate-box">
        <h2>Donate Blood</h2>
        <form action="" method="post">
            <label>Full Name
                <input name="fullname" type="text" placeholder="Full Name" required />
            </label>

            <label>Email
                <input name="email" type="email" placeholder="Email Address" required />
            </label>

            <label>Phone
                <input name="phone" type="text" placeholder="Phone Number" required />
            </label>

            <label>Blood Group
                <select name="bloodgroup" required>
                    <option value="">Select Blood Group</option>
                    <option value="A+">A+</option>
                    <option value="A-">A-</option>
                    <option value="B+">B+</option>
                    <option value="B-">B-</option>
                    <option value="O+">O+</option>
                    <option value="O-">O-</option>
                    <option value="AB+">AB+</option>
                    <option value="AB-">AB-</option>
                </select>
            </label>

            <label>Donation Date
                <input name="donation_date" type="date" required />
            </label>

            <label>Quantity (ml)
                <input name="quantity_ml" type="number" placeholder="Enter quantity in ml" required />
            </label>

            <label>Location
                <input name="location" type="text" placeholder="Donation Location" required />
            </label>

            <button name="submit" type="submit">Submit Donation</button>
        </form>
    </div>
</body>
</html>
