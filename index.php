<?php 
    // require('connection.php');
    session_start();

    $host = 'localhost';
    $user = 'root';
    $password = '';
    $db = 'learning';

    $link = mysqli_connect($host, $user, $password, $db);

    $link = mysqli_connect($host, $user, $password, $db);
    if (!$link) {
        die("Database connection failed: " . mysqli_connect_error());
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Cloth Rental System - User Page</title>
    <!-- <link rel="stylesheet" href="styles.css"> -->
    <style>
        /* Basic Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Body Styling */
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            color: #333;
        }

        .img-section{
            height: 600px;
            width: 100%;
            background: url(clothes.jpg);
            background-size: cover;
        }

        /* Header Styling */
        header {
            background-color: #2c3e50;
            color: #fff;
            padding: 20px 0;
            text-align: center;
        }

        header .container {
            max-width: 1000px;
            margin: 0 auto;
        }

        header h1 {
            font-size: 2.5rem;
        }

        p.login{
            background-color:rgb(42, 47, 44); 
            color: white;
            display: flex;
            justify-content: end;
            font-size: 25px;
            padding: 8px;
        }

        p.login a {
            color: #e74c3c;
            text-decoration: none;
            font-weight: bold;
        }

        /* Clothes Section */
        .clothes-section {
            background-color: #fff;
        }

        .clothes-section .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .clothes-section h2 {
            font-size: 2rem;
            margin-bottom: 20px;
            text-align: center;
        }

        .clothes-list {
            display: flex;
            flex-wrap: wrap;
            /* justify-content: space-around; */
        }

        .cloth-item {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            width: 250px;
            padding: 20px;
            margin: 10px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
        }

        .cloth-item a{
            text-decoration: none;
            color: #fff;
        }

        .cloth-item a:hover{
            text-decoration: none;
            color: rgb(40, 47, 29);
            font-size: 20px;
        }

        .cloth-item:hover {
            transform: scale(1.05);
        }

        .cloth-item img {
            width: 100%;
            height: auto;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        .cloth-item h3 {
            font-size: 1.5rem;
            color: #333;
            margin-bottom: 10px;
        }

        .cloth-item .description {
            font-size: 1rem;
            color: #777;
            margin-bottom: 10px;
        }

        .cloth-item .price {
            font-size: 1rem;
            font-weight: bold;
            color: #27ae60;
            margin-bottom: 20px;
        }

        .add-to-cart {
            background-color:rgb(78, 95, 247);
            color: #fff;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            font-size: 1rem;
            border-radius: 5px;
        }

        .add-to-cart:hover {
            background-color:rgb(8, 72, 248);
        }

        .foott{
            margin-top: 30px;
        }

        /* Footer Styling */
        footer .footer-section {
            display: flex;
            justify-content: center;
            margin-top: 2px;
            background-color:rgb(48, 55, 79);
            color: #fff;
            padding: 20px 0;
            text-align: center;
            text-align: left;
        }

        .foot{
            /* border: 2px solid white; */
            margin-right: 50px;
        }

        footer .footer-section h3 {
            color:rgb(123, 235, 252);
            font-size: 1.2rem;
            margin-bottom: 10px;
        }

        footer .footer-section p {
            font-size: 1rem;
            color: #ddd;
            line-height: 1.6;
        }

        footer p {
            margin-top: 2px;
            color: #fff;
            padding: 20px 0;
            text-align: center;
            font-size: 1rem;
            background-color: #2c3e50;
        }

     </style>
</head>
<body>
    <!-- Header Section -->
    <header>
        <div class="container">
            <h1>Welcome to the Online Cloth Rental System</h1>
            <marquee behavior="scroll" scrollamount="10" direction="left">
                <h1>
                    ~ Welcome to the Online Cloth Rental System ~
                </h1>
            </marquee>
        </div>
    </header>
    <p class="login"> 
        <a href="index.php" style="margin-right: 60%; color:#fff">OCRS</a>
        <a href="about.php" class="logout" style="margin-right: 2%;">About Us</a>
        Hello,    
        <span id="username">User </span> || <a href="SignUp_LogIn_Form.php"> Login or Register</a></p>

    <!-- Clothes Listing Section -->
    <section class="clothes-section">
    <div class="img-section">
    </div>
        <div class="container">
            <h2>~ Available Clothes for Rent ~</h2>

            <div class="clothes-list">

                <!-- Cloth Item 1 -->
                <!-- <div class="cloth-item">
                    <img src="image/saree.jpg" alt="Cloth 1">
                    <h3>Saree</h3> -->
                    <!-- <p class="description">An elegant red dress perfect for formal events.</p> -->
                    <!-- <p class="price">rs.1500 per day</p>
                    <button class="add-to-cart"><a href="
                        booking.html">Book Now</a></button>
                </div> -->

                <?php
                    $sql = "SELECT * FROM `clothes`";
                    $run = mysqli_query($link, $sql);
                    $count = mysqli_num_rows($run);
                ?>
                <?php
                    while ($row = mysqli_fetch_assoc($run)) {
                        if(isset($_SESSION['email'])){ 
                ?>
                <?php
                    } else { 
                ?>
                    <a style="cursor:pointer" onclick="alert('Please Login First')"></a>
                
                <?php } ?>

                <div class="cloth-item">
                    <img class="card-img-top" src="image/<?php echo $row['image']; ?>" alt="Card image cap">
                    <h3><?php echo $row['name']; ?></h3>
                    <p class="price"> Rent Price(per day): Rs <?php echo $row['price']; ?></p>
                    <button class="add-to-cart" onclick="showPopup()">Book Now</button>
                </div>  

                <script>
                    function showPopup() {
                        alert("Login or Register First");
                        window.location.href = "SignUp_Login_Form.php";
                    }
                </script>

                <?php } ?>
                
            </div>
        </div>
    </section>

    <!-- Footer Section -->
    <div class="foott"></div>
<footer>
    <div class="container">
        <!-- Contact Us and About Us Section -->
        <div class="footer-section">
            <div class="foot">
                <h3>Contact Us</h3>
                <h4>Email: roshanprajapati7064@gmail.com OR rushikeshtawale@gmail.com</h4>
                <h4>Phone: +91 9794442828 & 8369391516</h4>
                <h4>Address: Mahadev Collection , Indira Nagar, Road No. 22, Thane (400604), <br> Maharashtra, India</h4>
                </div>
                <div class="foot">
                <h3>About Us</h3>
                <h4>We are an online cloth rental service providing a wide range <br> of traditional and modern clothing for your special <br> occasions at affordable prices.</h4>
            </div>
        </div>
    </div>
    <p>&copy; 2025 Online Cloth Rental System.</p>
</footer>


</body>
</html>