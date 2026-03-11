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
    <link rel="stylesheet" type="text/css" href="./public/css/donate.css">
</head>
<body>
    <a href="index.php" class="home-btn">Home</a>
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
                <input name="donation_date" type="date" min="<?php echo date(
                    "Y-m-d",
                ); ?>" required />
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
            <p>Fullname: <?php echo $row["fullName"]; ?></p>
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
