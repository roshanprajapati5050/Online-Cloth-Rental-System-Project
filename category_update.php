<?php
// Database Connection
$host = 'localhost';
$user = 'root';
$password = '';
$db = 'learning';

$conn = mysqli_connect($host, $user, $password, $db);
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

session_start();
if(!isset($_SESSION['AdminLoginId']))
    {
        header("location: index.php");
    }

$category_id = '';
$category_name = '';

// If 'update' parameter is set in URL, fetch category data
if (isset($_GET['update'])) {
    $category_id = $_GET['update'];
    $fetch_query = "SELECT * FROM category WHERE category_id = '$category_id'";
    $fetch_result = mysqli_query($conn, $fetch_query);
    if (mysqli_num_rows($fetch_result) > 0) {
        $row = mysqli_fetch_assoc($fetch_result);
        $category_name = $row['category_name'];
    } else {
        echo "<script>alert('Category not found!'); window.location.href='category.php';</script>";
    }
}

// Update category name
if (isset($_POST['update_category'])) {
    $new_name = mysqli_real_escape_string($conn, $_POST['category_name']);
    $id = $_POST['category_id'];

    $update_query = "UPDATE category SET category_name = '$new_name' WHERE category_id = '$id'";
    if (mysqli_query($conn, $update_query)) {
        echo "<script>alert('Category updated successfully!'); window.location.href='category.php';</script>";
    } else {
        echo "<script>alert('Failed to update category.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Update Category</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
        }

        .dashboard {
            display: flex;
            font-size: 1.5rem;
        }

        .navbar {
            background-color: #343a40;
            padding: 15px;
            display: flex;
        }

        .home {
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

        .container {
            width: 50%;
            margin: 80px auto;
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        input[type="text"] {
            margin-top: 10px;
            width: 97%;
            padding: 12px;
            font-size: 18px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #218838;
        }

        .back-btn {
            background-color: #007bff;
            margin-top: 10px;
        }

        .back-btn:hover {
            background-color: #0056b3;
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

    <div class="container">
        <h2>Update Category</h2>
        <form action="" method="POST">
            <input type="hidden" name="category_id" value="<?php echo $category_id; ?>">
            <label>Category Name:</label>
            <input type="text" name="category_name" value="<?php echo $category_name; ?>" required>
            <button type="submit" name="update_category">Update Category</button>
        </form>
        <a href="category.php"><button class="back-btn">Back to Categories</button></a>
    </div>

</body>

</html>