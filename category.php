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

$message = [];

//Add New Category Logic
if (isset($_POST['add_product'])) {
    $category_name = mysqli_real_escape_string($conn, $_POST['category_name']);
    $check = mysqli_query($conn, "SELECT * FROM `category` WHERE category_name = '$category_name'");
    if (mysqli_num_rows($check) > 0) {
        $message[] = 'Category name already exists!';
    } else {
        $insert = mysqli_query($conn, "INSERT INTO `category` (category_name) VALUES ('$category_name')");
        if ($insert) {
            $message[] = 'Category added successfully!';
        }
    }
}

//Delete Category Logic with URL refresh
if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $check_assoc = mysqli_query($conn, "SELECT COUNT(*) AS count_products FROM `clothes` WHERE category_id = '$delete_id'");
    $assoc_result = mysqli_fetch_assoc($check_assoc);
    $num_products = $assoc_result['count_products'];

    if ($num_products > 0) {
        $message[] = "Cannot delete! $num_products product(s) are associated.";
    } else {
        $delete = mysqli_query($conn, "DELETE FROM `category` WHERE category_id = '$delete_id'");
        if ($delete) {
            $message[] = "Category deleted successfully!";
        } else {
            $message[] = "Failed to delete category.";
        }
    }
    header("Location: category.php");
    exit();
}

//Display Messages
foreach ($message as $msg) {
    echo "<script>alert('" . addslashes($msg) . "');</script>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Category Management</title>
    <style>
        body {
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        .navbar {
            background-color: #343a40;
            padding: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            margin: 0 10px;
            font-size: 18px;
        }

        .navbar a:hover {
            text-decoration: underline;
        }

        .container {
            padding: 30px;
            text-align: center;
        }

        .card {
            background-color: white;
            padding: 20px;
            max-width: 400px;
            margin: 20px auto;
            border-radius: 8px;
            box-shadow: 0 0 10px #ccc;
        }

        .card input[type="text"] {
            width: 90%;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            border: 1px solid #aaa;
            font-size: 16px;
        }

        .card button {
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            font-size: 16px;
        }

        .card button:hover {
            background-color: #218838;
        }

        .category-list {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            margin-top: 30px;
        }

        .category-box {
            background-color: #fff;
            width: 200px;
            height: 85px;
            border: 1px solid #ccc;
            margin: 15px;
            border-radius: 8px;
            padding: 15px;
            box-shadow: 0 0 8px #ccc;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .category-box .name {
            font-size: 18px;
            font-weight: bold;
            color: #333;
        }

        .category-box a {
            padding: 8px;
            text-decoration: none;
            border-radius: 5px;
            font-size: 14px;
            color: #fff;
            display: inline-block;
            width: 80px;
            text-align: center;
            margin: 5px auto;
        }

        .update-btn {
            background-color:#007bff;
        }

        .update-btn:hover {
            background-color: #0056b3;
        }

        .delete-btn {
            background-color: #dc3545;
        }

        .delete-btn:hover {
            background-color: #c82333;
        }
    </style>
</head>

<body>

    <div class="navbar">
        <div><a href="dashboard.php">Dashboard</a></div>
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
    </div>

    <div class="container">
        <form action="" method="POST">
            <div class="card">
                <h3>ADD NEW CATEGORY</h3>
                <input type="text" name="category_name" placeholder="Enter category name" required>
                <button type="submit" name="add_product">Add Category</button>
            </div>
        </form>

        <div class="category-list">
            <?php
            $select_categories = mysqli_query($conn, "SELECT * FROM category") or die('Query Failed');
            if (mysqli_num_rows($select_categories) > 0) {
                while ($category = mysqli_fetch_assoc($select_categories)) {
            ?>
                    <div class="category-box">
                        <div class="name"><?php echo $category['category_name']; ?></div>
                        <div class="btnn">
                            <a href="category_update.php?update=<?php echo $category['category_id']; ?>" class="update-btn">Update</a>
                            <a href="category.php?delete=<?php echo $category['category_id']; ?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete this category?');">Delete</a>
                        </div>
                    </div>
            <?php
                }
            } else {
                echo '<p>No categories added yet!</p>';
            }
            ?>
        </div>
    </div>

</body>

</html>
