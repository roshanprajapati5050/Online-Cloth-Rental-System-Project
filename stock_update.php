<?php

// Database connection
$host = 'localhost';
$user = 'root';
$password = '';
$db = 'learning';

$conn = mysqli_connect($host, $user, $password, $db);

session_start();
if(!isset($_SESSION['AdminLoginId']))
    {
        header("location: index.php");
    }

$message = [];

//Update Stock Functionality
if (isset($_POST['update_product'])) {
    $stock_id = mysqli_real_escape_string($conn, $_POST['stock_id']);
    $new_stock = mysqli_real_escape_string($conn, $_POST['stock']);

    //Update stock query
    mysqli_query($conn, "UPDATE `stock` SET stock = '$new_stock' WHERE id = '$stock_id'") or die('Query failed');
    $message[] = "Stock updated successfully!";
}

//Fetch All Stocks for Selected Cloth
$update_id = $_GET['cloth'] ?? '';  
$select_stocks = mysqli_query($conn, "SELECT * FROM `stock` WHERE cloth_id = '$update_id'") or die('Query failed');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Stock</title>

    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
            font-family: Arial, sans-serif;
        }
        .navbar {
            background-color: #343a40;
            padding: 15px;
            display: flex;
            justify-content: space-between;
        }
        .navbar a {
            color: white;
            text-decoration: none;
            margin: 0 15px;
            font-size: 18px;
        }
        .navbar a:hover {
            text-decoration: underline;
        }
        .update-product {
            margin-top: 50px;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
        }
        .form-container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 300px;
        }
        h3 {
            font-size: 20px;
            color: #333;
            margin-bottom: 10px;
        }
        .size-name {
            font-size: 18px;
            font-weight: bold;
            color: #555;
            margin-bottom: 15px;
        }
        input.box {
            width: 93%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }
        .btn {
            width: 100%;
            padding: 10px;
            background-color: #ff3399;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            margin-bottom: 10px;
        }
        .btn:hover {
            background-color: #e60073;
        }
        .option-btn {
            display: inline-block;
            text-decoration: none;
            color: #fff;
            background: #333;
            padding: 10px;
            border-radius: 5px;
            font-size: 14px;
        }
        .option-btn:hover {
            background: #555;
        }
    </style>
</head>
<body>

<nav class="navbar">
    <div>
        <a href="dashboard.php">Dashboard</a>
    </div>
    <div>
        <a href="dashboard.php">Home</a>
        <a href="add.php">Cloth</a>
        <a href="size.php">Size</a>
        <a href="category.php">Categories</a>
        <a href="placedorder.php">Rent Clothes</a>
        <a href="return.php">Return</a>
        <a href="userinfo.php">User Info</a>
        <a style="color: red; font-size: 20px;" href="index.php">Logout</a>
    </div>
</nav>

<section class="update-product">
    <?php 
    if (mysqli_num_rows($select_stocks) > 0) {
        while ($fetch_stock = mysqli_fetch_assoc($select_stocks)) {
            //Fetch Size Name
            $size_name = "Size Not Found";
            $size_id = $fetch_stock['size_id'];
            $select_size = mysqli_query($conn, "SELECT name FROM `size` WHERE id = '$size_id'") or die('Query failed');
            if ($fetch_size = mysqli_fetch_assoc($select_size)) {
                $size_name = $fetch_size['name'];
            }
    ?>
        <div class="form-container">
            <form action="" method="post">
                <input type="hidden" value="<?php echo $fetch_stock['id']; ?>" name="stock_id">

                <h3>Update Your Stock</h3>
                <p class="size-name">Size: <?php echo $size_name; ?></p> <!--Size Name Display -->

                <input type="number" min="0" class="box" value="<?php echo $fetch_stock['stock']; ?>" required placeholder="Update product stock" name="stock">
                <input type="submit" value="Update Stock" name="update_product" class="btn">
            </form>
        </div>
    <?php 
        } 
    } else { 
        echo '<p class="empty">No stock found for this product.</p>'; 
    } 
    ?>
</section>

<?php
//Show Alerts
foreach ($message as $msg) {
    echo "<script>alert('" . addslashes($msg) . "');</script>";
}
?>

</body>
</html>
