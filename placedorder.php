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

//Fetch all rental orders with payment status
$fetch_query = "SELECT r.*, ru.full_name, ru.email 
                FROM rent r
                JOIN registered_user ru ON r.user_id = ru.user_id";

$result = mysqli_query($con, $fetch_query);

//Handle payment status update
if (isset($_POST['update_status'])) {
    $rent_id = $_POST['rent_id'];
    $payment_status = $_POST['payment_status'];

    //Update payment status
    $update_payment_query = "UPDATE rent SET payment_status='$payment_status' WHERE rent_id='$rent_id'";
    if (mysqli_query($con, $update_payment_query)) {
        echo "<script>alert('Payment status updated successfully!'); window.location.href='placedorder.php';</script>";
    } else {
        echo "<script>alert('Error updating payment status!');</script>";
    }
}

//**Handle order deletion (with return request deletion)**
if (isset($_POST['delete_order'])) {
    $rent_id = $_POST['rent_id'];

    //First, delete related return request if it exists
    $delete_return_query = "DELETE FROM `return` WHERE rent_id='$rent_id'";
    mysqli_query($con, $delete_return_query);

    //Now, delete the rent order
    $delete_query = "DELETE FROM rent WHERE rent_id='$rent_id'";
    if (mysqli_query($con, $delete_query)) {
        echo "<script>alert('Order and related return request deleted successfully!'); window.location.href='placedorder.php';</script>";
    } else {
        echo "<script>alert('Error deleting order!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Placed Orders</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: rgb(241, 240, 240);
            text-align: center;
        }
        h2{
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
            color: hotpink;
            font-weight: bold;
        }
        .status-dropdown {
            width: 100%;
            padding: 5px;
            margin-top: 5px;
        }
        .update-btn, .delete-btn {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            border-radius: 5px;
            cursor: pointer;
            border: none;
        }
        .update-btn {
            background-color: orange;
            color: white;
        }
        .delete-btn {
            background-color: red;
            color: white;
        }
    </style>
</head>
<body>
    
<?php @include 'admin_header.php'; ?>

<h2>PLACED ORDERS</h2>

<?php
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $rent_id = $row['rent_id'];
        $cloth_id = $row['cloth_id'];
        $full_name = $row['full_name'];
        $email = $row['email'];
        $payment_method = $row['method'];
        $rent_date = $row['rent_date'];
        $return_date = $row['return_date'];
        $rental_days = (new DateTime($rent_date))->diff(new DateTime($return_date))->days;
        $total_price = $row['rental_price'] * $rental_days;
        $payment_status = $row['payment_status'];
        $address=$row['address'];
        $mobile=$row['mobile'];

        echo '<div class="order-container">
            <p>Rent ID: <span class="highlight">' . $rent_id . '</span></p>
            <p>Cloth ID: <span class="highlight">' . $cloth_id . '</span></p>
            <p>Full Name: <span class="highlight">' . $full_name . '</span></p>
            <p>Email: <span class="highlight">' . $email . '</span></p>
            <p>Payment Method: <span class="highlight">' . $payment_method . '</span></p>
            <p>Rent Date: <span class="highlight">' . $rent_date . '</span></p>
            <p>Return Date: <span class="highlight">' . $return_date . '</span></p>
            <p>Rental Days: <span class="highlight">' . $rental_days . ' day(s)</span></p>
            <p>Rental Price: <span class="highlight">RS' . $total_price . '</span></p>
            <p>User Address: <span class="highlight">' . $address . '</span></p>
            <p>User Phone no: <span class="highlight">' . $mobile . '</span></p>
            
            <form method="POST">
                <input type="hidden" name="rent_id" value="' . $rent_id . '">

                <!-- Payment Status Dropdown -->
                <br><label>Payment Status:</label>
                <select name="payment_status" class="status-dropdown">
                    <option value="pending" ' . ($payment_status == "pending" ? "selected" : "") . '>Pending</option>
                    <option value="paid" ' . ($payment_status == "paid" ? "selected" : "") . '>Paid</option>
                </select>

                <button type="submit" name="update_status" class="update-btn">Update</button>
            </form>

            <form method="POST">
                <input type="hidden" name="rent_id" value="' . $rent_id . '">
                <button type="submit" name="delete_order" class="delete-btn">Delete</button>
            </form>
        </div>';
    }
} else {
    echo "<p>No orders found!</p>";
}
?>

</body>
</html>
