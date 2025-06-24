<?php
require('connection.php');
session_start();

if (isset($_POST['login'])) {
    $email_username = trim($_POST['email_username']);
    $password = $_POST['password'];

    $query = "SELECT * FROM `registered_user` WHERE `email` = ? OR `username` = ?";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "ss", $email_username, $email_username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        
        if (password_verify($password, $user['password'])) {
            session_unset();
            session_destroy();
            session_start();
            session_regenerate_id(true);

            //**Session Set**
            $_SESSION['logged_in'] = true;
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];

            //**Store Session Fingerprint**
            $_SESSION['fingerprint'] = md5($_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT']);

            echo "<script>alert('Login Successful');window.location.href='main.php';</script>";
            exit();
        } else {
            echo "<script>alert('Incorrect Password');window.location.href='SignUp_Login_Form.php';</script>";
        }
    } else {
        echo "<script>alert('Email or Username Not Registered');window.location.href='SignUp_LogIn_Form.php';</script>";
    }
}


//**Handle Registration**
if (isset($_POST['register'])) {
    $fullname = trim($_POST['fullname']);
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $register_date = date("Y-m-d");

    $check_query = "SELECT * FROM `registered_user` WHERE `username` = ? OR `email` = ?";
    $stmt = mysqli_prepare($con, $check_query);
    mysqli_stmt_bind_param($stmt, "ss", $username, $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) > 0) {
        echo "<script>alert('Username or Email already exists');window.location.href='SignUp_LogIn_Form.php';</script>";
    } else {
        $insert_query = "INSERT INTO `registered_user` (`full_name`, `username`, `email`, `password`, `register_date`) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($con, $insert_query);
        mysqli_stmt_bind_param($stmt, "sssss", $fullname, $username, $email, $password, $register_date);

        if (mysqli_stmt_execute($stmt)) {
            // ✅ **New session for registered user**
            session_unset();
            session_destroy();
            session_start();
            session_regenerate_id(true);

            $_SESSION['logged_in'] = true;
            $_SESSION['user_id'] = mysqli_insert_id($con);
            $_SESSION['username'] = $username;
            $_SESSION['email'] = $email;

            echo "<script>alert('Registration Successful');window.location.href='main.php';</script>";
            exit();
        } else {
            echo "<script>alert('Registration Failed');window.location.href='SignUp_Login_Form.php';</script>";
        }
    }
}
?>
