<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "blood_db");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST["submit"])) {
    $date = $_POST["donation_date"];
    $type = $_POST["bloodgroup"];

    $reqSql = "
        SELECT
            users.fullName,
            users.email,
            users.phone,
            request.reqDate,
            request.ml
        FROM request
        JOIN users ON users.userID = request.userID
        JOIN blood ON blood.bloodID = request.bloodID
        WHERE request.reqDate <= '$date'
        AND blood.bloodID = '$type'
    ";
} else {
    $reqSql = "
        SELECT
            users.fullName,
            users.email,
            users.phone,
            request.reqDate,
            request.ml
        FROM request
        JOIN users ON users.userID = request.userID
    ";
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Donate Blood - Blood Bank</title>
    <style>
        .donate-box {
            background: #fff;
            margin: 50px auto;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            width: 350px;
        }
        h2 {
            text-align: center;
            color: #b30000;
            margin-bottom: 20px;
        }
        .donate-box form {
            display: flex;
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
        .request-box {
            margin: 30px auto;
            width: 80%;
            max-width: 800px;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        .request-card {
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 15px;
            display: flex;
            justify-content: space-between;
        }
        .left-side, .right-side {
            display: flex;
            gap: 10px;
            flex-direction: column;
        }
        p{
            font-weight:600;
            color:#333;
            text-size:12px;
            font-family:Arial, Helvetica, sans-serif;
        }
        .left-side{
            flex-grow: 1;
            justify-content: flex-start;
        }
        .left-side *{
            margin-right: 15px;
        }
        .right-side{
            width: 200px;
        }
    </style>
</head>
<body>
    <div class="donate-box">
        <h2>Donate Blood</h2>
        <form action="" method="post">
            <label>Blood Group
                <select name="bloodgroup" required>
                    <?php
                    $sql = "SELECT * FROM blood";
                    $result = mysqli_query($conn, $sql);
                    while ($row = mysqli_fetch_assoc($result)) { ?>
                                    <option value="<?php echo $row[
                                        "bloodID"
                                    ]; ?>"><?php echo $row[
    "bloodType"
]; ?></option>
                                    <?php }
                    ?>
                </select>
            </label>

            <label>Donation Date
                <input name="donation_date" type="date" required />
            </label>

            <button name="submit" type="submit">search</button>
        </form>
    </div>
<?php $result = mysqli_query($conn, $reqSql); ?>
<div class="request-box">
    <h2>Requests</h2>
    <?php if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) { ?>
    <div class="request-card" >
        <div class="left-side">
            <p>fullname: <?php echo $row["fullName"]; ?></p>
            <p>Email: <?php echo $row["email"]; ?></p>
            <p>Phone: <?php echo $row["phone"]; ?></p>
        </div>
        <div class="right-side">
            <p>Request Date: <?php echo $row["reqDate"]; ?></p>
            <p>Request ML: <?php echo $row["ml"]; ?></p>
        </div>
    </div>
<?php }
    } else {
         ?>
    <p>No requests found.</p>
<?php
    } ?>
</div>
</body>
</html>
