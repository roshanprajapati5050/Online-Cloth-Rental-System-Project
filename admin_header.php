<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <title>header</title> -->
     <style>
        body{
            padding: 0;
            margin: 0;
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
            color: black;
            padding: 10px;
            margin-right: 20px;
        }

        .logout:hover{
            color: white;
            background-color: rgb(77, 87, 71);
        }
        
        .header h2{
            padding: 8px;
            margin: 0;
        }
     </style>
</head>
<body>
    <div class="header">
        <a href="index.php" class="logout"> Logout</a>
        <a href="userinfo.php" class="logout"> User Info</a>
        <a href="return.php" class="logout"> Return</a>
        <a href="placedorder.php" class="logout"> Rent Cloths</a>
        <a href="size.php" class="logout"> Size</a>
        <a href="category.php" class="logout"> Categories</a>
        <a href="add.php" class="logout"> Cloth</a>
        <a href="dashboard.php" class="logout"> Dashboard</a>
        <h2>Admin Dashboard</h2>
    </div>
</body>
</html>