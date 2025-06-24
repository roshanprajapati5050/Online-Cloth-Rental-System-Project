<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <title>header</title> -->
     <style>
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
            margin-right: 50px;
        }

        .logout:hover{
            border-radius: 10px;
            color: white;
            background-color: rgb(61, 61, 61);
        }
        
        .header h2{
            padding: 8px;
            margin: 0;
        }
     </style>
</head>
<body>
    <div class="header">
        <a href="logout.php" class="logout">Logout</a>
        <a href="mybooking.php" class="logout">MyBooking</a>
        <a href="about.php" class="logout">About Us</a>
        <a href="contect.php" class="logout">Contact Us</a>
        <a href="main.php" class="logout">Home</a>
        <h2>Cloth Rental</h2>
    </div>
</body>
</html>