<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blood Bank Management System</title>
    <style>
        /* Reset */
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
            background-color: #b30000; /* Dark Red */
            color: white;
            padding: 20px;
            text-align: center;
        }

        header h1 {
            font-size: 2.5rem;
            letter-spacing: 2px;
        }

        nav {
            background-color: #ff3333; /* Bright Red */
            display: flex;
            justify-content: center;
            padding: 10px;
        }
.user{
    color: white;
    font-size: large;
}
        nav a {
            color: white;
            text-decoration: none;
            margin: 0 20px;
            font-weight: bold;
            transition: 0.3s;
        }

        nav a:hover {
            color: #000;
            background-color: #fff;
            padding: 5px 10px;
            border-radius: 5px;
        }

        .hero {
            background: url('image/img5.png') no-repeat center center/cover;
            height: 400px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-shadow: 2px 2px 5px #000;
        }

        .hero h2 {
            font-size: 2.5rem;
        }

        .container {
            padding: 40px;
            text-align: center;
        }

        .container h3 {
            color: #b30000;
            margin-bottom: 20px;
        }

        .btn {
            display: inline-block;
            background-color: #b30000;
            color: white;
            padding: 12px 25px;
            margin: 10px;
            border-radius: 5px;
            text-decoration: none;
            transition: 0.3s;
        }

        .btn:hover {
            background-color: #ff3333;
        }

        footer {
            background-color: #b30000;
            color: white;
            text-align: center;
            padding: 15px;
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <header>
        <h1>Blood Bank Management System</h1>
        <p>Saving Lives Through Blood Donation</p>
    </header>

    <nav>
        <?php 
       if(isset($_SESSION['fullname'])) {
        echo "<strong class='user' >".$_SESSION['fullname']."</strong>";
       ?>
        <a href="logout.php">Logout</a>
       <?php }else{
        ?>
        <?php } ?>
        <a href="Home.php">Home</a>
         <a href="Request.php">Request Blood</a>
        <a href="Donate.php">Donate Blood</a>
          <a href="Donationhistory.php">Donation History</a>
        <a href="Requesthistory.php">Request History</a>
        <a href="contact.php">Contact</a>
    </nav>

    <section class="hero">
        
        
    </section>

    <div class="container">
        <h3>Welcome to Our Blood Bank Management System</h3>
        <p>
             Our mission is to show the timely available blood here you can see the details of donors, 
      hospitals, and patients.
        </p>
    </div>

    <footer>
        <p>&copy; 2025 Blood Bank Management System | Designed by Suyana and kriti</p>
    </footer>
</body>
</html>
