<?php
session_start();

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

//Fetch all return requests with user details
$query = "SELECT r.id, r.rent_id, r.status, ru.full_name, ru.email, rt.rent_date, rt.return_date
          FROM `return` r
          JOIN rent rt ON r.rent_id = rt.rent_id
          JOIN registered_user ru ON rt.user_id = ru.user_id";
$result = mysqli_query($con, $query);

//Handle Return Status Update
if (isset($_POST['update_status'])) {
    $return_id = $_POST['return_id'];
    $status = $_POST['status'];

    $update_query = "UPDATE `return` SET status='$status' WHERE id='$return_id'";
    if (mysqli_query($con, $update_query)) {
        echo "<script>alert('Return status updated successfully!'); window.location.href='return.php';</script>";
    } else {
        echo "<script>alert('Error updating status.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Returns</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: rgb(241, 240, 240);
            text-align: center;
        }
        .container {
            max-width: 900px;
            margin: 50px auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center;
            font-size: 14px;
        }
        th {
            background-color: hotpink;
            color: white;
        }
        select {
            padding: 5px;
        }
        .update-btn {
            background-color: orange;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 5px;
        }
        .update-btn:hover {
            background-color: darkorange;
        }
    </style>
</head>
<body>

<?php @include 'admin_header.php'; ?>

<div class="container">
    <h2>Manage Return Requests</h2>

    <table>
        <tr>
            <th>Return ID</th>
            <th>Rent ID</th>
            <th>User Name</th>
            <th>Email</th>
            <th>Rent Date</th>
            <th>Return Date</th>
            <th>Status</th>
            <th>Action</th>
        </tr>

        <?php
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['rent_id']}</td>
                    <td>{$row['full_name']}</td>
                    <td>{$row['email']}</td>
                    <td>{$row['rent_date']}</td>
                    <td>{$row['return_date']}</td>
                    <td>
                        <form method='POST'>
                            <input type='hidden' name='return_id' value='{$row['id']}'>
                            <select name='status'>
                                <option value='pending' " . ($row['status'] == 'pending' ? 'selected' : '') . ">Pending</option>
                                <option value='approved' " . ($row['status'] == 'approved' ? 'selected' : '') . ">Approved</option>
                                <option value='cancelled' " . ($row['status'] == 'cancelled' ? 'selected' : '') . ">Cancelled</option>
                            </select>
                    </td>
                    <td>
                            <button type='submit' name='update_status' class='update-btn'>Update</button>
                        </form>
                    </td>
                </tr>";
            }
        } else {
            echo "<tr><td colspan='8'>No return requests found</td></tr>";
        }
        ?>
    </table>
</div>

</body>
</html>
