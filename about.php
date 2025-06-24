<?php
session_start();

$host = 'localhost';
$user = 'root';
$password = '';
$db = 'learning';
$conn = mysqli_connect($host, $user, $password, $db);
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }
        .container {
            width: 80%;
            margin: auto;
            padding: 10px 0;
            text-align: center;
        }
        h1 {
            font-size: 36px;
            color: #333;
        }
        p {
            font-size: 18px;
            color: #555;
            line-height: 1.6;
        }
        .team-section {
            margin-top: 50px;
        }
        .team {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
        }
        .member {
            margin: 15px;
            padding: 20px;
            background: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            width: 250px;
            text-align: center;
        }
        .member img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
        }
        .contact {
            margin-top: 50px;
        }
    </style>
</head>
<body>

    <?php @include 'header.php'; ?>

    <div class="container">
        <h1>About Us</h1>
        <p>Welcome to <strong>ONLINE CLOTH RENTAL SYSTEM</strong>, where we provide high-quality clothing rentals at the best prices. 
           Our mission is to make fashion affordable and accessible to everyone without compromising on style.</p>

        <p>Founded in 2024, we aim to be your go-to destination for trendy, high-quality clothing rentals. Whether you need 
           outfits for special occasions, casual wear, or something unique, we've got you covered!</p>

        <div class="team-section">
            <h2>Meet Our Team</h2>
            <div class="team">
                <div class="member">
                    <img src="image/roshan.jpg" alt="Team Member">
                    <h3>Roshan Prajapati</h3>
                    <p>Developer & Customer Support</p>
                </div>
                <div class="member">
                    <img src="image/rushikesh.jpg" alt="Team Member">
                    <h3>Rushikesh Tawale</h3>
                    <p>Developer & Customer Support</p>
                </div>
            </div>
        </div>

        <div class="contact">
            <h2>Contact Us</h2>
            <p>Email: roshanprajapati7064@gmail.com OR rushikeshtawale@gmail.com</p>
            <p>Phone: +91 97944 42828 & +91 83693 91516</p>
        </div>
    </div>

</body>
</html>
