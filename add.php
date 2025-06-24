<?php
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
$message = "";

if(isset($_POST['submit'])){
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    
    $target_dir = "../image/";
    $target_file = $target_dir . basename($_FILES['image']["name"]);
    move_uploaded_file($_FILES['image']["tmp_name"], $target_file);
    
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $category_id = mysqli_real_escape_string($conn, $_POST['category_id']);

    $select_product_name = mysqli_query($conn, "SELECT * FROM clothes WHERE name = '$name'") or die(mysqli_error($conn));

    if(mysqli_num_rows($select_product_name) > 0){
        $message = 'Cloth name already exists!';
    } else {
        $insert_product = mysqli_query($conn, "INSERT INTO clothes(name, image, price, category_id) VALUES ('$name','$target_file','$price','$category_id')") or die(mysqli_error($conn));
        if($insert_product){
            $message = 'Cloth added successfully!';
        }
    }
}

if(isset($_GET['delete'])){
    $delete_id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM clothes WHERE cloth_id = '$delete_id'") or die(mysqli_error($conn));
    header('location: add.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product Information</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        background: #f1f2f2;
        margin: 0;
        padding: 0;
    }

    h2{
        text-align: center;
    }

    .form-container {
        width: 50%;
        margin: 20px auto;
        text-align: center;
    }

    .form-box {
        background: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
    }

    .form-box input{
        width: 95%;
        padding: 10px;
        margin: 10px 0;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    .form-box select {
        width: 98%;
        padding: 10px;
        margin: 10px 0;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    .container {
        width: 100%;
        margin: 20px auto;
        text-align: center;
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

    .box {
        border: 1px solid #ccc;
        padding: 15px;
        border-radius: 8px;
        background: white;
        display: inline-block;
        width: 250px;
        margin: 15px;
        box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
    }

    .box img {
        width: 100%;
        height: auto;
        border-radius: 10px;
    }

    .option-btn {
        display: inline-block;
        padding: 10px;
        border-radius: 5px;
        text-decoration: none;
        margin-top: 10px;
        font-size: 14px;
    }

    .btn-warning {
        background-color: orange;
        color: white;
        padding: 8px 15px;
        border-radius: 5px;
        text-decoration: none;
        display: inline-block;
        margin-top: 10px;
    }

    .btn-add {
        background-color: blue;
        color: white;
        font-size: 25px;
        padding: 8px 15px;
        border-radius: 5px;
        text-decoration: none;
        display: inline-block;
        margin-top: 10px;
    }

    .btn-danger {
        background-color: red;
        color: white;
        padding: 8px 15px;
        border-radius: 5px;
        text-decoration: none;
        display: inline-block;
        margin-top: 10px;
    }
</style>

    <script>
        function showAlert(message) {
            if (message) {
                alert(message);
            }
        }
    </script>

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

    <h2>Add Product Information</h2>

    <div class="form-container">
        <div class="form-box">

        <?php
            if (!empty($message)) {
                echo "<script>showAlert('$message');</script>";
            }
        ?>

        <form action="" method="post" enctype="multipart/form-data">
            <input type="text" name="name" placeholder="Enter Cloth Name" required><br>
            <input type="text" name="price" placeholder="Enter Cloth Price" required><br>

            <select name="category_id" required>
                <option value="" selected disabled>Select Category</option>
                <?php
                $select_category = mysqli_query($conn, "SELECT * FROM category") or die(mysqli_error($conn));
                if (mysqli_num_rows($select_category) > 0) {
                    while ($fetch_category = mysqli_fetch_assoc($select_category)) {
                ?>
                        <option value="<?php echo $fetch_category['category_id']; ?>"><?php echo $fetch_category['category_name']; ?></option>
                <?php
                    }
                } else {
                    echo '<p>No categories found!</p>';
                }
                ?>
            </select><br>

            <input type="file" name="image" required><br>

            <input type="submit" name="submit" class="btn-add" value="Add Cloth">
        </form>
        </div>
    </div>

        <div class="form-container">
            <a href="../index.php" class="btn-warning">Go to User Page</a>
        </div>

    <div class="container">
        <h2>Added Clothes</h2>
        <?php
        $select_products = mysqli_query($conn, "SELECT * FROM clothes") or die(mysqli_error($conn));
        if (mysqli_num_rows($select_products) > 0) {
            while ($fetch_products = mysqli_fetch_assoc($select_products)) {
        ?>
                <div class="box">
                    <h3>Rs.<?php echo $fetch_products['price']; ?></h3>
                    <h3>Cloth Id..<?php echo $fetch_products['cloth_id']; ?></h3>
                    <img src="../uploaded_img/<?php echo $fetch_products['image']; ?>" alt="Cloth Image">
                    <h2><?php echo $fetch_products['name']; ?></h2>

                    <?php
                    $cloth_id = $fetch_products['cloth_id'];
                    $select_stock = mysqli_query($conn, "SELECT * FROM stock WHERE cloth_id = '$cloth_id'") or die(mysqli_error($conn));

                    $has_stock = false; // Default: No stock available

                    if (mysqli_num_rows($select_stock) > 0) {
                        while ($fetch_stock = mysqli_fetch_assoc($select_stock)) {
                            $size_id = $fetch_stock['size_id'];
                            $stock_quantity = $fetch_stock['stock'];

                            $select_size = mysqli_query($conn, "SELECT * FROM size WHERE id = '$size_id'") or die(mysqli_error($conn));

                            if (mysqli_num_rows($select_size) > 0) {
                                while ($fetch_size = mysqli_fetch_assoc($select_size)) {
                                    echo "<p>" . $fetch_size['name'] . ": " . $stock_quantity . "</p>";

                                    // If stock is greater than 0, set $has_stock to true
                                    if ($stock_quantity >= 0) {
                                        $has_stock = true;
                                    }
                                }
                            }
                        }
                    } else {
                        echo "<p>Stock not available</p>";
                    }
                    ?>

                    <a href="stock.php?cloth=<?php echo $cloth_id; ?>" class="option-btn" style="background-color: blue; color:white;">Add Stock</a><br>

                    <?php if ($has_stock ) { ?>
                        <a href="stock_update.php?cloth=<?php echo $cloth_id; ?>" class="option-btn" style="background-color: lightgreen; color:black;">Update Stock</a>
                    <?php } ?>
                    
                    <br>
                    <a href="cloth_update.php?update=<?php echo $fetch_products['cloth_id']; ?>" class="btn-warning">Update</a>
                    <a href="add.php?delete=<?php echo $fetch_products['cloth_id']; ?>" class="btn-danger" onclick="return confirm('Delete this category?');">Delete</a>
                </div>
        <?php
            }
        } else {
            echo '<p>No products added yet!</p>';
        }
        ?>
    </div>

</body>
</html>