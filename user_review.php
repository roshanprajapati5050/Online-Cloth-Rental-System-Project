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
if(!isset($_SESSION['AdminLoginId']))
    {
        header("location: index.php");
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All User Reviews (With Cloth Name)</title>
    <style>
        body {
            background-color: rgba(143, 167, 170, 0.1);
            font-family: Arial;
        }

        .star-display .filled {
            color: goldenrod;
            font-size: 20px;
        }

        .star-display .empty {
            color: #ddd;
            font-size: 20px;
        }

        .reviews-container {
            display: flex;
            flex-wrap: wrap;
            margin: 30px auto;
            max-width: 95%;
        }

        .review {
            width: 300px;
            background: #fff;
            padding: 15px;
            margin: 10px;
            border-radius: 8px;
            box-shadow: 0 0 8px rgba(0, 0, 0, 0.1);
        }

        .review p {
            margin: 5px 0;
        }

        .review .cloth-name {
            color: #007BFF;
            font-weight: bold;
            font-size: 18px;
        }

        h2 {
            text-align: center;
            margin-top: 30px;
        }
    </style>
</head>

<body>
<?php @include 'admin_header.php'; ?>

<h2>All Reviews with Cloth Names</h2>

<div class="reviews-container">
    <?php
    //Fetch reviews with cloth names
    $review_query = mysqli_query($link, "
        SELECT cr.*, ru.username, c.name AS cloth_name 
        FROM cloth_reviews cr 
        JOIN registered_user ru ON cr.user_id = ru.user_id
        JOIN clothes c ON cr.cloth_id = c.cloth_id
        ORDER BY cr.created_at DESC
    ") or die('Query Failed');

    if (mysqli_num_rows($review_query) > 0) {
        while ($row = mysqli_fetch_assoc($review_query)) {
            echo '<div class="review">
                    <div class="cloth-name">Cloth: ' . htmlspecialchars($row['cloth_name']) . '</div>
                    <strong>User: ' . htmlspecialchars($row['username']) . '</strong>
                    <p>' . htmlspecialchars($row['review']) . '</p>
                    <div class="star-display">';
            echo str_repeat('<span class="filled">&#9733;</span>', $row['rating']);
            echo str_repeat('<span class="empty">&#9733;</span>', 5 - $row['rating']);
            echo '</div>
                    <small>' . date("d M Y, h:i A", strtotime($row['created_at'])) . '</small>
                  </div>';
        }
    } else {
        echo "<p style='text-align:center;'>No reviews yet!</p>";
    }
    ?>
</div>

</body>

</html>
