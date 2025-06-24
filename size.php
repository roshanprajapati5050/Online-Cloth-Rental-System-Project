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

//Add Size Logic
if (isset($_POST['add_size'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $check = mysqli_query($conn, "SELECT * FROM `size` WHERE name = '$name'") or die(mysqli_error($conn));

    if (mysqli_num_rows($check) > 0) {
        $message[] = 'Size name already exists!';
    } else {
        $insert = mysqli_query($conn, "INSERT INTO `size` (name) VALUES ('$name')") or die(mysqli_error($conn));
        $message[] = $insert ? 'Size added successfully!' : 'Failed to add size.';
    }
}

//Delete Size Logic
if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM `size` WHERE id = '$delete_id'") or die('Delete query failed');
    header('Location: size.php');
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
    <title>Size Management</title>
    <style>
        body {
            background-color: #f9f9f9;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .navbar {
            background-color: #343a40;
            padding: 15px;
            display: flex;
            justify-content: space-between;
        }
        .navbar a {
            color: #fff;
            text-decoration: none;
            margin: 0 10px;
            font-size: 18px;
        }
        .navbar a:hover {
            text-decoration: underline;
        }
        .home{
            display: flex;
            gap: 18px;
            margin-left: 45%;
        }
        .container {
            padding: 30px;
            text-align: center;
        }
        .form-box {
            background-color: #fff;
            padding: 20px;
            margin: auto;
            width: 350px;
            border-radius: 8px;
            box-shadow: 0 0 10px #ccc;
        }
        .form-box input[type="text"] {
            width: 90%;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            border: 1px solid #aaa;
        }
        .form-box button {
            padding: 10px 25px;
            background-color: #28a745;
            color: #fff;
            border-radius: 5px;
            border: none;
            cursor: pointer;
        }
        .form-box button:hover {
            background-color: #218838;
        }
        .size-list {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            margin-top: 30px;
        }
        .size-card {
            background-color: #fff;
            padding: 15px;
            width: 200px;
            margin: 10px;
            border-radius: 8px;
            box-shadow: 0 0 8px #ccc;
            text-align: center;
        }
        .delete-btn {
            margin-top: 15px;
            display: inline-block;
            background-color: #fa4747;
            color: #fff;
            padding: 8px 15px;
            border-radius: 5px;
            text-decoration: none;
        }
        .delete-btn:hover {
            background-color: darkred;
        }
    </style>
</head>

<body>

    <div class="navbar">
        <a href="dashboard.php">Dashboard</a>
        <div class="home">
            <a href="dashboard.php">Home</a>
            <a href="add.php">Cloth</a>
            <a href="size.php">Size</a>
            <a href="category.php">Categories</a>
            <a href="placedorder.php">Rent Clothes</a>
            <a href="return.php">Return</a>
            <a href="userinfo.php">User Info</a>
        </div>
        <a style="color: red;" href="index.php">Logout</a>
    </div>

    <div class="container">
        <div class="form-box">
            <h2>Add New Size</h2>
            <form action="" method="POST">
                <input type="text" name="name" placeholder="Enter Size" required>
                <button type="submit" name="add_size">Add Size</button>
            </form>
        </div>

        <h2 style="margin-top: 40px;">Added Sizes</h2>
        <div class="size-list">
            <?php
                $size_query = mysqli_query($conn, "SELECT * FROM `size`") or die('Query Failed');
                if (mysqli_num_rows($size_query) > 0) {
                    while ($size = mysqli_fetch_assoc($size_query)) {
                        echo '<div class="size-card">';
                        echo "<strong>Size: " . htmlspecialchars($size['name']) . "</strong><br>";
                        echo "<a href='size.php?delete={$size['id']}' class='delete-btn' onclick=\"return confirm('Are you sure you want to delete this size?');\">Delete</a>";
                        echo '</div>';
                    }
                } else {
                    echo '<p>No sizes added yet!</p>';
                }
            ?>
        </div>
    </div>

</body>
</html>
