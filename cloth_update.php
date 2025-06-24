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

if (isset($_POST['update_product'])) {
    $update_p_id = $_POST['update_p_id'];
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $category_id = mysqli_real_escape_string($conn, $_POST['category_id']); 
    $old_image = $_POST['update_p_image']; // Old image path

    //Step 1: Name, Price, Category Update
    mysqli_query($conn, "UPDATE `clothes` SET name = '$name', price = '$price', category_id = '$category_id' WHERE cloth_id = '$update_p_id'") or die(mysqli_error($conn));
    
    //Step 2: Image Update Logic
    if (!empty($_FILES['image']['name'])) {
        $target_dir = "../image/";
        $target_file = $target_dir . basename($_FILES['image']["name"]);
        $image_size = $_FILES['image']['size'];

        if ($image_size > 2000000) {
            $message[] = 'Image file size is too large!';
        } else {
            //Move New Image
            move_uploaded_file($_FILES['image']["tmp_name"], $target_file);

            //Delete Old Image (agar exist karti hai)
            if (!empty($old_image) && file_exists($old_image)) {
                unlink($old_image);
            }

            //Update Image Path in Database
            mysqli_query($conn, "UPDATE `clothes` SET `image` = '$target_file' WHERE cloth_id = '$update_p_id'") or die(mysqli_error($conn));
            $message[] = 'Image updated successfully!';
        }
    }

    $message[] = 'Product updated successfully!';
}

//Display Alerts (PHP Messages)
foreach ($message as $msg) {
    echo "<script>alert('" . addslashes($msg) . "');</script>";
}

//Fetch Product Data for Update
$update_id = $_GET['update'];
$select_products = mysqli_query($conn, "SELECT * FROM `clothes` WHERE cloth_id = '$update_id'") or die('Query failed');
$fetch_products = mysqli_fetch_assoc($select_products);
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Update Product</title>
   <style>
        body {
            background-color: #f5f5f5;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .dashboard{
            display: flex;
            font-size: 1.5rem;
        }

        .navbar {
            background-color: #343a40;
            padding: 15px;
            display: flex;
        }
        
        .home{
            margin-left: 45%;
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
            display: flex;
            justify-content: center;
            align-items: center;   
            margin-top: 50px;
        }
        form {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 350px;
        }
        .image {
            width: 80%;
            height: auto;
            border-radius: 8px;
            margin-bottom: 15px;
        }
        .box {
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
    </style>
</head>
<body>

    <nav class="navbar">
        <div class="dashboard">
            <a href="dashboard.php">Dashboard</a>
        </div>
        <div class="home">
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
    <form action="" method="post" enctype="multipart/form-data">
        <img src="<?php echo !empty($fetch_products['image']) ? $fetch_products['image'] : '../image/default.png'; ?>" class="image" alt="Product Image">
        <input type="hidden" value="<?php echo $fetch_products['cloth_id']; ?>" name="update_p_id">
        <input type="hidden" value="<?php echo $fetch_products['image']; ?>" name="update_p_image">
        <input type="text" class="box" value="<?php echo $fetch_products['name']; ?>" required placeholder="Update product name" name="name">
        <input type="number" min="0" class="box" value="<?php echo $fetch_products['price']; ?>" required placeholder="Update product price" name="price">
        
        <select name="category_id" class="box">
            <option value="" disabled>Select category</option>
            <?php
            $select_category = mysqli_query($conn, "SELECT * FROM `category`") or die('Query failed');
            while ($fetch_category = mysqli_fetch_assoc($select_category)) {
                $selected = ($fetch_category['category_id'] == $fetch_products['category_id']) ? 'selected' : '';
                echo "<option value='{$fetch_category['category_id']}' {$selected}>{$fetch_category['category_name']}</option>";
            }
            ?>
        </select>

        <input type="file" accept="image/jpg, image/jpeg, image/png" class="box" name="image">
        <input type="submit" value="Update Product" name="update_product" class="btn">
        <a href="add.php" class="btn" style="background-color: #ff9900;">Go Back</a>
    </form>
</section>

</body>
</html>
