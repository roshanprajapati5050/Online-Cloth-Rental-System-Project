<?php
session_start();

//Database Connection
$host = 'localhost';
$user = 'root';
$password = '';
$db = 'learning';

$con = mysqli_connect($host, $user, $password, $db);
if (!$con) {
    die("Database connection failed: " . mysqli_connect_error());
}

if(!isset($_SESSION['AdminLoginId']))
    {
        header("location: index.php");
    }

//Fetch all users
$fetch_query = "SELECT * FROM registered_user";
$result = mysqli_query($con, $fetch_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Info</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: rgb(241, 240, 240);
            text-align: center;
        }
        h2 {
            margin-top: 50px;
        }
        .user-container {
            display: inline-flex;
            flex-direction: column;
            width: auto;
            background: white;
            padding: 20px;
            margin: 20px;
            border-radius: 8px;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
        }
        .user-container p {
            display: flex;
            flex-direction: row;
            font-size: 16px;
            color: #333;
            margin: 8px 0;
        }
        .highlight {
            color: rgba(10, 105, 146, 0.9);
            font-weight: bold;
        }
    </style>
</head>
<body>

<?php @include 'admin_header.php'; ?>

<h2>USER INFORMATION</h2>

<?php
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<div class="user-container">
            <p>User ID: <span class="highlight">' . $row['user_id'] . '</span></p>
            <p>Full Name: <span class="highlight">' . $row['full_name'] . '</span></p>
            <p>Username: <span class="highlight">' . $row['username'] . '</span></p>
            <p>Email: <span class="highlight">' . $row['email'] . '</span></p>
            <p>Register Date: <span class="highlight">' . $row['register_date'] . '</span></p>
        </div>';
    }
} else {
    echo "<p>No users found!</p>";
}
?>

</body>
</html>
