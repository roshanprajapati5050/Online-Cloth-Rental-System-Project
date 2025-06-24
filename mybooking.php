<?php
session_start();
session_regenerate_id(true);

//Database Connection
$host = 'localhost';
$user = 'root';
$password = '';
$db = 'learning';

$con = mysqli_connect($host, $user, $password, $db);
if (!$con) {
    die("Database connection failed: " . mysqli_connect_error());
}

//Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Please login first'); window.location.href='SignUp_Login_Form.php';</script>";
    exit();
}


$user_id = $_SESSION['user_id']; 

//Handle Return Request Submission
if (isset($_POST['return_product'])) {
    $rent_id = $_POST['rent_id'];

    // Check if a return request already exists
    $check_query = "SELECT * FROM `return` WHERE rent_id='$rent_id'";
    $check_result = mysqli_query($con, $check_query);

    if (mysqli_num_rows($check_result) == 0) {
        // Insert new return request
        $insert_query = "INSERT INTO `return` (rent_id, status) VALUES ('$rent_id', 'pending')";
        if (mysqli_query($con, $insert_query)) {
            echo "<script>alert('Return request submitted successfully!'); window.location.href='mybooking.php';</script>";
        } else {
            echo "<script>alert('Error submitting return request.');</script>";
        }
    } else {
        echo "<script>alert('Return request already exists.');</script>";
    }
}

//Handle Order Cancellation
if (isset($_POST['cancel_order'])) {
    $rent_id = $_POST['rent_id'];

    //Delete the order from the `rent` table
    $delete_query = "DELETE FROM rent WHERE rent_id='$rent_id' AND user_id='$user_id'";
    
    if (mysqli_query($con, $delete_query)) {
        echo "<script>alert('Order cancelled successfully!'); window.location.href='mybooking.php';</script>";
    } else {
        echo "<script>alert('Error cancelling order.');</script>";
    }
}

//Fetch Only Current User's Rent Orders
$query = "SELECT rent.*, clothes.image, clothes.name 
          FROM rent 
          JOIN clothes ON rent.cloth_id = clothes.cloth_id
          WHERE rent.user_id='$user_id' 
          ORDER BY rent.rent_date DESC";
$result = mysqli_query($con, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Bookings</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: rgb(241, 240, 240);
        }
        .order-section {
            text-align: center;
            margin-top: 50px;
        }
        .order-container {
            display: inline-block;
            width: 300px;
            background: white;
            padding: 20px;
            margin: 20px;
            border-radius: 8px;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
        }
        .order-container p {
            display: flex;
            flex-direction: row;
            font-size: 16px;
            color: #333;
            margin: 8px 0;
        }
        .highlight {
            margin-left: 10px;
            color: blue;
            font-weight: bold;
        }
        .return-btn, .cancel-btn {
            display: block;
            width: 100%;
            color: white;
            border: none;
            padding: 10px;
            margin-top: 10px;
            border-radius: 5px;
            cursor: pointer;
        }
        .return-btn {
            background-color: hotpink;
        }
        .cancel-btn {
            background-color: red;
        }
        .return-btn:disabled, .cancel-btn:disabled {
            background-color: grey;
            cursor: not-allowed;
        }
    </style>
</head>
<body>
<?php @include 'header.php'; ?>

<div class="order-section">
    <h2>MY BOOKINGS</h2>
    <h3 style="color: blue; text-align:center;">
        <strong style="color: red;">Note:</strong> You will be charged with extra 
        <span style="color: red;">Rs. 150</span> for each day after the due date ends.
    </h3>

    <?php
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $rent_id = $row['rent_id'];
                $rent_date = new DateTime($row['rent_date']);
                $return_date = new DateTime($row['return_date']);
                $interval = $rent_date->diff($return_date);
                $rental_days = $interval->days;
                $total_price = $row['rental_price'] * $rental_days;
                $payment_status = $row['payment_status'];

                //Check if return request exists
                $return_status = "";
                $return_query = "SELECT status FROM `return` WHERE rent_id='$rent_id'";
                $return_result = mysqli_query($con, $return_query);
                if (mysqli_num_rows($return_result) > 0) {
                    $return_row = mysqli_fetch_assoc($return_result);
                    $return_status = $return_row['status'];
                }

                echo '<div class="order-container">
                    <img src="uploads/' . $row['image'] . '" alt="Cloth Image" style="width:100%; height:auto; border-radius:5px;">
                    <h3 style="color: red;">' . $row['name'] . '</h3>
                    <p>Rent ID: <span class="highlight">'. $rent_id . '</span></p>
                    <p>Username: <span class="highlight">'. ($_SESSION['username'] ?? "N/A") . '</span></p>
                    <p>Email: <span class="highlight">' . ($_SESSION['email'] ?? "N/A") . '</span></p>
                    <p>Payment Method: <span class="highlight">' . $row['method'] . '</span></p>
                    <p>Rent Date: <span class="highlight">' . $row['rent_date'] . '</span></p>
                    <p>Return Date: <span class="highlight">' . $row['return_date'] . '</span></p>
                    <p>Rental Days: <span class="highlight">' . $rental_days . ' day(s)</span></p>
                    <p>Rental Price: <span class="highlight">Rs' . $total_price . '/-</span></p><br>
                    <p>Payment Status: <span class="highlight">' . ucfirst($payment_status) . '</span></p>';

                    
                if ($return_status == "pending") {
                    echo '<p><br> Your return request is <span class="highlight"><br>pending</span>.</p>';
                } elseif ($return_status == "approved") {
                    echo '<p><br> Your return request has been <span class="highlight"><br>approved</span>.</p>';
                } else {
                    echo '<form method="POST"><br>
                        <input type="hidden" name="rent_id" value="' . $rent_id . '">
                        <button type="submit" name="cancel_order" class="cancel-btn" onclick="return confirm(\'Are you sure you want to cancel this order?\');">Cancel Booking</button>
                        <button type="submit" name="return_product" class="return-btn">Return Product</button>
                    </form>';
                }

                echo '</div>';
            }
        } else {
            echo "<p>No orders found!</p>";
        }
    ?>
</div>

</body>
</html>
