<?php 
    require('connection.php');
    session_start();
    if(!isset($_SESSION['AdminLoginId']))
    {
        header("location: index.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="dashboard.css">
</head>
<body>
    <div class="sidebar">
        <h2>~ OCRS ~</h2>
        <a href="dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
        <a href="add.php"><i class="fas fa-tshirt"></i> Cloth</a>
        <a href="category.php"><i class="fas fa-list"></i> Categories</a>
        <a href="size.php"><i class="fas fa-ruler"></i> Size</a>
        <a href="placedorder.php"><i class="fas fa-shopping-cart"></i> Rent Cloths</a>
        <a href="return.php"><i class="fas fa-undo"></i> Return</a>
        <a href="userinfo.php"><i class="fas fa-user"></i> User Info</a>
        <a href="contect_message.php"><i class="fas fa-message"></i> Contact Message </a>
        <a href="index.php"><i class="fas fa-lock"></i> Log Out </a>
    </div>
    <div class="main-content">
        <div class="top-bar">
            <div class="name-hyper-link">
                <a href="dashboard.php" style="text-decoration: none; color: white;">Online Cloth Rental System Dashboard</a>
                <a href="\learn\index.php" style="text-decoration: none; color: rgba(242, 251, 79, 1);">Go to User Page</a>
            </div>
            <div class="dropdown">
                <button><i class="fas fa-user"></i></button>
                <div class="dropdown-content">
                    <a href="#">Admin : <span style="color: rgb(251, 7, 157);"><?php echo $_SESSION ['AdminLoginId']?></span></a>
                    <a href="index.php">Log Out</a>
                </div>
            </div>
        </div>
        <h1>Dashboard</h1>
        <div class="stats">
            <div class="stat-card blue">
                Total normal user
                <?php
                    $select_users = mysqli_query($con, "SELECT * FROM `registered_user`") or die('query failed');
                    $number_of_users = mysqli_num_rows($select_users);
                ?>
                <h3><?php echo $number_of_users; ?></h3>
                <a class="cards" href="userinfo.php">More info</a>
            </div>
            <div class="stat-card yellow">
                Cloths added 
                <?php
                    $select_cloth = mysqli_query($con, "SELECT * FROM `clothes`") or die('query failed');
                    $total_added_cloth = mysqli_num_rows($select_cloth);
                ?>
                <h3><?php echo $total_added_cloth; ?></h3>
                <a class="cards" href="add.php">More info</a>
            </div>
            <div class="stat-card green">
                Order Placed 
                <?php
                    $order_placed = mysqli_query($con, "SELECT * FROM `rent`") or die('query failed');
                    $total_order_placed = mysqli_num_rows($order_placed);
                ?>
                <h3><?php echo $total_order_placed; ?></h3>
                <a class="cards" href="placedorder.php">More info</a>
            </div>
            <div class="stat-card red">
                Return
                <?php
                    $return_cloth = mysqli_query($con, "SELECT * FROM `return`") or die('query failed');
                    $total_return_cloth = mysqli_num_rows($return_cloth);
                ?>
                <h3><?php echo $total_return_cloth; ?></h3>
                <a class="cards" href="return.php">More info</a>
            </div>
            <div class="stat-card red">
                Total Admin
                <?php
                    $select_admin = mysqli_query($con, "SELECT * FROM `admin_login`") or die('query failed');
                    $number_of_admin = mysqli_num_rows($select_admin);
                ?>
                <h3><?php echo $number_of_admin; ?></h3>
            </div>
            <div class="stat-card blue">
                Total Categories
                <?php
                    $select_category = mysqli_query($con, "SELECT * FROM `category`") or die('query failed');
                    $number_of_category = mysqli_num_rows($select_category);
                ?>
                <h3><?php echo $number_of_category; ?></h3>
                <a class="cards" href="category.php">More info</a>
            </div>
            <div class="stat-card yellow">
                Available Size 
                <?php
                    $select_size = mysqli_query($con, "SELECT * FROM `size`") or die('query failed');
                    $total_added_cloth = mysqli_num_rows($select_size);
                ?>
                <h3><?php echo $total_added_cloth; ?></h3>
                <a class="cards" href="size.php">More info</a>
            </div>
            <div class="stat-card green">
                Contact message
                <?php
                    $contect_message = mysqli_query($con, "SELECT * FROM `contact_messages`") or die('query failed');
                    $total_contect_message = mysqli_num_rows($contect_message);
                ?>
                <h3><?php echo $total_contect_message; ?></h3>
                <a class="cards" href="contect_message.php">More info</a>
            </div>
            <div class="stat-card green">
                User Reviews 
                <?php
                    $user_review = mysqli_query($con, "SELECT * FROM `cloth_reviews`") or die('query failed');
                    $total_user_review = mysqli_num_rows($user_review);
                ?>
                <h3><?php echo $total_user_review; ?></h3>
                <a class="cards" href="user_review.php">More info</a>
            </div>
        </div>
    </div>
</body>
</html>
