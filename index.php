<?php
    require("connection.php");
    session_start();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login Panel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"/>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="login-form">
        <h2>ADMIN LOGIN PANEL</h2>
        <form action="" method="POST">
            <div class="input-field">
                <div class="icon"><i class="fas fa-user"></i></div>
                <input type="text" placeholder="Admine Name" name="AdminName">
            </div>

            <div class="input-field">
                <div class="icon"><i class="fas fa-lock"></i></div>
                <input type="password" placeholder="Enter Password" name="AdminPassword">
            </div>

            <button type="submit" name="Signin">Loggin</button>

            <!-- <div class="extra">
                <a href="#">Forgot Password?</a>
            </div> -->
        </form>
    </div>

    <?php
        if(isset($_POST['Signin']))
        {
            $query="SELECT * FROM `admin_login` WHERE `Admin_Name`='$_POST[AdminName]' AND `Admin_Password`='$_POST[AdminPassword]'";

            $result=mysqli_query($con,$query);
            if(mysqli_num_rows($result)==1)
            {
                session_start();
                $_SESSION['AdminLoginId']=$_POST['AdminName'];
                header("location: dashboard.php");
            }
            else
            {
                echo "<script>alert('Incorrect Password');</script>";
            }
        }
    ?>

</body>
</html>