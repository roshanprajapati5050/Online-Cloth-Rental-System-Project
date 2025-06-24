<?php

    $host = 'localhost';
    $user = 'root';
    $password = '';
    $db = 'learning';

    $link = mysqli_connect($host, $user, $password, $db);

    $conn=$link;

    session_start();
    if(!isset($_SESSION['AdminLoginId']))
        {
            header("location: index.php");
        }

    $message = [];

    if (isset($_POST['add_product'])) {
        $cloth_id = mysqli_real_escape_string($conn, $_POST['cloth_id']);

        $stock = mysqli_real_escape_string($conn, $_POST['stock']); // Adding stock field
        $size_id = mysqli_real_escape_string($conn, $_POST['size_id']); // Adding size field

        $insert_product = mysqli_query($conn, "INSERT INTO `stock` (cloth_id,size_id, stock) VALUES ('$cloth_id','$size_id', '$stock')") or die(mysqli_error($conn));

        if ($insert_product) {
            $message[] = 'Stock added successfully!';
        }
        header('location: add.php');
    }
    foreach ($message as $msg) {
        echo "<script>alert('" . addslashes($msg) . "');</script>"; //Show alert
    
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>products</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
            align-items: center;
            gap: 20px;
        }

        .form-container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 350px;
        }

        input{
            width: 94%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }

        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }

        .btn {
            background-color: #ff3399;
            color: white;
            padding: 10px;
            border: none;
            width: 100%;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #e60073;
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

<div class="update-product">
    <div class="form-container">
        <form action="" method="POST" enctype="multipart/form-data">
     
        <div class="flex">
            <div class="inputBox">
                <?php
                    if (isset($_GET['cloth'])) {
                    $cloth_id = $_GET['cloth'];
                    $update_query = mysqli_query($conn, "SELECT * FROM `clothes` WHERE cloth_id = '$cloth_id'") or die('query failed');
                    if (mysqli_num_rows($update_query) > 0) {
                    $fetch_update = mysqli_fetch_assoc($update_query);
                ?>
            </div>
            <h3>add <?php echo $fetch_update['name']; ?> stock</h3>
            <input type="hidden"  class="box" required value="<?php echo $fetch_update['cloth_id']; ?>"name="cloth_id">
        </div>
        <?php
                }
            } else {
                echo '<script>document.querySelector(".form-container1").style.display = "none";</script>';
            }
        ?>
        <input type="number" min="0" class="box" required placeholder="enter cloth stock" name="stock">
        <select name="size_id" class="box">
            <option value="" selected disabled>select size</option>
                <?php
                $select_category = mysqli_query($conn, "SELECT * FROM `size`") or die('query failed');
                if (mysqli_num_rows($select_category) > 0) {
                    while ($fetch_category = mysqli_fetch_assoc($select_category)) {
                        // Extracting data from a database 
                        ?>
                        <option value="<?php echo $fetch_category['id']; ?>"><?php echo $fetch_category['name']; ?></option>
                <?php
                    }
                } else {
                    echo '<p class="empty">no size!</p>';
                }
                ?>
            </select>  

            <!-- <button type="submit" class="btn">Add Stock</button> -->
            <input type="submit" value="add stock" name="add_product" class="btn">
        </form>
    </div>
</div>
</body>
</html>