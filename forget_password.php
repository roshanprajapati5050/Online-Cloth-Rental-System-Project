<?php
$host = 'localhost';
$user = 'root';
$password = '';
$db = 'learning';

$link = mysqli_connect($host, $user, $password, $db);
if (!$link) {
    die("Database connection failed: " . mysqli_connect_error());
}
session_start();

if (isset($_POST['submit'])) {
    $email_username = trim($_POST['email_username']);
    $new_password = trim($_POST['new_password']);

    // Check if user exists
    $query = "SELECT * FROM `registered_user` WHERE `email` = ? OR `username` = ?";
    $stmt = mysqli_prepare($link, $query);
    mysqli_stmt_bind_param($stmt, "ss", $email_username, $email_username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) == 1) {
        // User found, update password
        $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);
        $update_query = "UPDATE `registered_user` SET `password` = ? WHERE `email` = ? OR `username` = ?";
        $stmt = mysqli_prepare($link, $update_query);
        mysqli_stmt_bind_param($stmt, "sss", $hashed_password, $email_username, $email_username);
        
        if (mysqli_stmt_execute($stmt)) {
            echo "<script>alert('Password Reset Successful!'); window.location.href='SignUp_Login_Form.php';</script>";
        } else {
            echo "<script>alert('Error Updating Password'); window.location.href='forget_password.php';</script>";
        }
    } else {
        echo "<script>alert('User Not Registered!'); window.location.href='forget_password.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forget Password</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
        }
        .header{
            background-color: rgb(229, 231, 231);
            height: 45px;
            padding: 5px;
            font-weight: 500;
            font-size: 1.5rem;
         }

        .logout {
            float: right;
            text-decoration: none;
            color: rgb(73, 53, 69);
            padding: 10px;
            margin-right: 100px;
        }

        .logout:hover{
            color: white;
            background-color: rgb(114, 135, 102);
        }
        
        .header h2{
            padding: 8px;
            margin: 0;
        }
        .container {
            margin-top: 100px;
            width: 30%;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px 0px #0000001a;
            margin-left: auto;
            margin-right: auto;
        }
        input {
            width: 90%;
            padding: 10px;
            margin-top: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        button {
            width: 95%;
            padding: 10px;
            margin-top: 15px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="header">
        <a href="about.php" class="logout">About Us</a>
        <a href="contect.php" class="logout">Contect Us</a>
        <a href="main.php" class="logout">Home</a>
        <h2>Cloth Rental</h2>
    </div>
    <div class="container">
        <h2>Reset Password</h2>
        <form method="POST">
            <label>Email or Username:</label>
            <input type="text" name="email_username" required>
            <br>
            <label>New Password:</label>
            <input type="password" name="new_password" required>
            <br>
            <button type="submit" name="submit">Reset Password</button>
        </form>
    </div>
</body>
</html>
