<?php
session_start();

$host = 'localhost';
$user = 'root';
$password = '';
$db = 'learning';
$conn = mysqli_connect($host, $user, $password, $db);
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

if (!isset($_SESSION['email'])) {
    header("location: main.php");
    exit();
}

$email = $_SESSION['email'];
$user_query = mysqli_query($conn, "SELECT user_id FROM registered_user WHERE email = '$email'");
$user_data = mysqli_fetch_assoc($user_query);
$user_id = $user_data['user_id'];

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("location: main.php");
    exit();
}
$cloth_id = $_GET['id'];

$cloth = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM clothes WHERE cloth_id = '$cloth_id'"));

if (isset($_POST['submit'])) {
    $size_id = $_POST['size_id'];
    $rent_date = $_POST['rent_date'];
    $return_date = $_POST['return_date'];
    $cloth_quantity = $_POST['cloth_quantity'];
    $rental_price = $_POST['rental_price'];
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $mobile = mysqli_real_escape_string($conn, $_POST['mobile']);

    if (strlen($mobile) > 10) {
        $message = "Mobile number cannot exceed 10 digits!";
    } else if ($return_date < $rent_date) {
        $message = "Return date cannot be earlier than rent date.";
    } else {
        $stock_query = mysqli_query($conn, "SELECT stock FROM stock WHERE cloth_id = '$cloth_id' AND size_id = '$size_id'");
        $stock_row = mysqli_fetch_assoc($stock_query);
        if ($stock_row['stock'] >= $cloth_quantity) {
            $new_stock = $stock_row['stock'] - $cloth_quantity;
            mysqli_query($conn, "UPDATE stock SET stock = '$new_stock' WHERE cloth_id = '$cloth_id' AND size_id = '$size_id'");
            mysqli_query($conn, "INSERT INTO rent (user_id, cloth_id, size_id, rent_date, return_date, rental_price, method, payment_status, cloth_quantity, address, mobile) 
                                 VALUES ('$user_id', '$cloth_id', '$size_id', '$rent_date', '$return_date', '$rental_price', 'cash', 'pending', '$cloth_quantity', '$address', '$mobile')");
            $message = "Cloth booked successfully!";
        } else {
            $message = "Not enough stock available.";
        }
    }
}

//Review Submit
if (isset($_POST['submit_review'])) {
    $review = mysqli_real_escape_string($conn, $_POST['review']);
    $rating = $_POST['rating'];
    mysqli_query($conn, "INSERT INTO cloth_reviews (cloth_id, user_id, review, rating) VALUES ('$cloth_id', '$user_id', '$review', '$rating')");
    echo "<script>alert('Review submitted successfully!'); window.location.href='booking.php?id=$cloth_id';</script>";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Booking Page</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial;
            background-color:rgb(239, 239, 239);
        }

        h1{
            text-align: center;
            font-weight: 555;
            color: rgb(254, 4, 175);
        }

        .main{
            display: flex;
            justify-content: center;
            gap: 20px;
        }

        .container {
            width: 52%;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
        }

        .highlight {
            color: red;
            font-size: 20px;
        }

        .btn {
            width: 250px;
            background-color: green;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            margin-left: 35%;
        }

        input[type='date']{
            width: 20%;
            padding: 10px;
            margin: 5px 0;
        }

        textarea,
        input[type='text'],
        input[type='number'],
        select {
            width: 50%;
            padding: 10px;
            margin: 5px 0;
        }

        .rev{
            margin-left: 30%;
        }

        .review-section {
            margin: 1% 22.4%;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
        }

        .review {
            background: #f1f1f1;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        .reviews-container{
            display: flex;
            gap: 20px;
        }

        .star-display .filled {
            color: orange;
        }

        .star-display .empty {
            color: #ccc;
        }

        .stars span {
            font-size: 22px;
            cursor: pointer;
        }

        .stars span { 
            font-size: 30px; 
            cursor: pointer; 
            color: #ccc; 
        }

        .stars .selected { 
            color: orange !important; 
        }

        .stars .hovered { 
            color: orange; 
        }
    </style>
</head>

<body>
    <?php @include 'header.php'; ?>
    <h1>Booking Page</h1>
    <h3 style="color: blue; text-align:center;">
        <strong style="color: red;">Note:</strong> You will be charged with extra 
        <span style="color: red;">Rs. 150</span> for each day after the due date ends.
    </h3>
    <?php if (isset($message)) echo "<p style='color:green; font-size: 22px; text-align: center;'>$message</p>"; ?><br>
    <div class="main">
        <div class="container">
            <h2>Booking: <?php echo $cloth['name']; ?></h2>
            <img src="image/<?php echo $cloth['image']; ?>" width="200px" style="margin-left: 35%;"><br><br>
            <p>Price: <span class="highlight">Rs. <?php echo $cloth['price']; ?> per day</span></p>
            
            
            <form action="" method="POST">
                <label>Rent Date:</label><input type="date" name="rent_date" min="<?php echo date('Y-m-d'); ?>" required>
                <span>➡️</span>
                <label>Return Date:</label><input type="date" name="return_date" min="<?php echo date('Y-m-d'); ?>" required><br><br>
                <label>Select Size:</label>
                <?php
                $size_query = mysqli_query($conn, "SELECT stock.size_id, size.name FROM stock JOIN size ON stock.size_id = size.id WHERE stock.cloth_id='$cloth_id'");
                
                if (mysqli_num_rows($size_query) > 0) {
                    while ($size = mysqli_fetch_assoc($size_query)) {
                        echo "<input type='radio' name='size_id' value='{$size['size_id']}' required> {$size['name']} ";
                    }
                } else {
                    echo "<p style='color:red;'>Size not added yet!</p>";
                }
                ?><br><br>

            <label>Quantity:</label><input type="number" name="cloth_quantity" min="1" value="1" required><br><br>
            <label>Address:</label><textarea name="address" required></textarea><br><br>
            <label>Mobile:</label><input type="text" name="mobile" required><br>
            <input type="hidden" name="rental_price" value="<?php echo $cloth['price']; ?>"><br><br>
            <button type="submit" name="submit" class="btn">Book Now</button>
        </form>
    </div>
    </div>

    <!-- Review Section -->
    <div class="review-section container">
        <h3 style="text-align: center;">Write a Review</h3>
        <form method="POST">
            <div class="rev">
                <textarea name="review" placeholder="Write your review..." required></textarea><br>
                <label>Rating:</label>
                <div class="stars">
                    <input type="hidden" name="rating" id="rating-value" required>
                    <span class="star" data-value="1">&#9733;</span>
                    <span class="star" data-value="2">&#9733;</span>
                    <span class="star" data-value="3">&#9733;</span>
                    <span class="star" data-value="4">&#9733;</span>
                    <span class="star" data-value="5">&#9733;</span>
                </div><br>
            </div>

            <button type="submit" name="submit_review" class="btn">Submit Review</button>
        </form>

        <h3>All Reviews</h3>
        <div class="reviews-container">
            <?php
            $review_query = mysqli_query($conn, "SELECT cr.*, ru.username FROM cloth_reviews cr JOIN registered_user ru ON cr.user_id = ru.user_id WHERE cr.cloth_id='$cloth_id' ORDER BY cr.created_at DESC");
            if (mysqli_num_rows($review_query) > 0) {
                while ($row = mysqli_fetch_assoc($review_query)) {
                    echo '<div class="review">
                    <strong>' . htmlspecialchars($row['username']) . ':</strong>
                    <p>' . htmlspecialchars($row['review']) . '</p>
                    <div class="star-display">';
                    echo str_repeat('<span class="filled">&#9733;</span>', $row['rating']);
                    echo str_repeat('<span class="empty">&#9733;</span>', 5 - $row['rating']);
                    echo '</div><small>' . date("d M Y, h:i A", strtotime($row['created_at'])) . '</small></div>';
                }
            } else {
                echo "<p>No reviews yet!</p>";
            }
            ?>
        </div>
    </div>

    <!-- ✅ Star Rating JavaScript -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const stars = document.querySelectorAll(".star");
            const ratingValue = document.getElementById("rating-value");

            stars.forEach((star, index) => {
                star.addEventListener("click", function () {
                    const value = this.getAttribute("data-value");
                    ratingValue.value = value;

                    // Remove all selected classes first
                    stars.forEach(s => s.classList.remove("selected"));
                    
                    // Add selected class to selected stars
                    for (let i = 0; i < value; i++) {
                        stars[i].classList.add("selected");
                    }
                });

                // Optional Hover Effect
                star.addEventListener("mouseover", function () {
                    stars.forEach((s, i) => {
                        s.classList.toggle('hovered', i <= index);
                    });
                });
                star.addEventListener("mouseout", function () {
                    stars.forEach(s => s.classList.remove('hovered'));
                });
            });
        });
    </script>

</body>

</html>