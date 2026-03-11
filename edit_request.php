<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "blood_db");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$reqID = $_GET['id'];
$userID = $_SESSION['userID'];

$sql = "SELECT * FROM request WHERE reqID = '$reqID' AND userID = '$userID'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 0) {
    header("Location: requests.php");
    exit();
}

$row = mysqli_fetch_assoc($result);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $blood_group = $_POST["bloodGroup"];
    $quantity_ml = $_POST["quantity_ml"];
    $date = $_POST["date"];
    
    $updateSql = "UPDATE request SET bloodID='$blood_group', reqDate='$date', ml='$quantity_ml' WHERE reqID='$reqID'";
    if (mysqli_query($conn, $updateSql)) {
        header("Location: requests.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Request</title>
    <link rel="stylesheet" type="text/css" href="./public/css/request.css">
</head>
<body>
    <header>
        <h1>Edit Request</h1>
        <nav>
            <a href="index.php">Home</a>
            <a href="requests.php">Back to Requests</a>
        </nav>
    </header>
    <main class="container">
        <form action="" method="post">
            <label for="bloodGroup">Blood Group:</label>
            <select id="bloodGroup" name="bloodGroup" required>
                <?php
                $bloodSql = "SELECT * FROM blood";
                $bloodResult = mysqli_query($conn, $bloodSql);
                while ($bloodRow = mysqli_fetch_assoc($bloodResult)) { ?>
                    <option value="<?php echo $bloodRow["bloodID"]; ?>" <?php if($row['bloodID'] == $bloodRow['bloodID']) echo 'selected'; ?>><?php echo $bloodRow["bloodType"]; ?></option>
                <?php } ?>
            </select>

            <label for="quantity">Quantity (ml):</label>
            <input type="number" id="quantity" name="quantity_ml" value="<?php echo htmlspecialchars($row['ml']); ?>" required>

            <label for="date">Required Date:</label>
            <input type="date" id="date" name="date" value="<?php echo $row['reqDate']; ?>" min="<?php echo date('Y-m-d'); ?>" required>
            
            <button type="submit">Update Request</button>
        </form>
    </main>
</body>
</html>
<?php mysqli_close($conn); ?>
