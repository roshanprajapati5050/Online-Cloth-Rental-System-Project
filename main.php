<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: SignUp_LogIn_Form.php");
    exit();
}

$host = 'localhost';
$user = 'root';
$password = '';
$db = 'learning';

$link = mysqli_connect($host, $user, $password, $db);
if (!$link) {
    die("Database connection failed: " . mysqli_connect_error());
}

//Search functionality
$search_query = "";
if (isset($_GET['search'])) {
    $search_query = mysqli_real_escape_string($link, $_GET['search']);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Cloth Rental System - User Page</title>
    <link rel="stylesheet" href="main.css">
</head>

<body>
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
        <a href="main.php" style="margin-right: 30%; color:#fff">OCRS</a>
        <a href="main.php" class="logout">Home</a>
        <a href="#cloth" class="logout">All clothes</a>
        <a href="mybooking.php" class="logout">MyBooking</a>
        <a href="contect.php" class="logout">Contact Us</a>
        <a href="about.php" class="logout">About Us</a>
        Hello, 
        <span id="username">
            <?php 
                if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
                    echo $_SESSION['username']; //Show username if user is logged in.
                } else {
                    echo "Guest"; //Nahi hai toh Guest show karein
                }
            ?>
        </span>
        || <a href="logout.php" style="color:red"> LOGOUT </a>
    </p>
    
    <div class="search-container">
        <form method="GET" action="">
            <input type="text" name="search" placeholder="Search for clothes..." value="<?php echo htmlspecialchars($search_query); ?>">
            <button type="submit">Search</button>
        </form>
    </div>
    <div class="img-section">
        <!-- <img src="clothes.jpg" alt="cloth" class="cover"> -->
        <!--Search Box -->
    <section class="container">
        
        
    </div>
    
    <div class="available"><h2 style="color:rgb(108, 9, 24);">~ Available Clothes for Rent ~</h2></div>
        <div class="clothes-list" id="cloth">
            <?php
            //Search Filter
            if ($search_query != "") {
                $sql = "SELECT * FROM `clothes` WHERE `name` LIKE '%$search_query%'";
            } else {
                $sql = "SELECT * FROM `clothes`";
            }

            $run = mysqli_query($link, $sql);
            if (mysqli_num_rows($run) > 0) {
                while ($row = mysqli_fetch_assoc($run)) {
                    $link = isset($_SESSION['email']) ? "booking.php?id=" . $row['cloth_id'] : "javascript:alert('Please Login First')";
                    echo "<div class='cloth-item'>
                            <img src='image/{$row['image']}' alt='{$row['name']}'>
                            <h3>{$row['name']}</h3>
                            <p class='price'>Rent Price(per day): <br><span style='color: red;''> Rs {$row['price']}</span></p>
                            <button class='add-to-cart'><a href='{$link}' style='color:white;'>Book Now</a></button>
                          </div>";
                }
            } else {
                echo "<p style='text-align:center; font-size:1.2rem; color:red;'>No clothes found for '<b>$search_query</b>'</p>";
            }
            ?>
        </div>
    </section>

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
