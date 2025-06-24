<?php
// Database Connection
$host = "localhost";  
$user = "root";       
$password = "";       
$dbname = "learning"; 

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

session_start();
if(!isset($_SESSION['AdminLoginId']))
    {
        header("location: index.php");
    }

// Handle Delete Request
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $conn->prepare("DELETE FROM contact_messages WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "<script>alert('Message deleted successfully!');</script>";
        echo "<script>window.location.href='contect_message.php';</script>";
    } else {
        echo "<script>alert('Error deleting message. Please try again.');</script>";
    }
    $stmt->close();
}

// Fetch All Messages
$sql = "SELECT id, name, email, message, submitted_at FROM contact_messages ORDER BY submitted_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Messages - Admin</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f8f8;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: 3% auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #28a745;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .delete-btn {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 8px 12px;
            cursor: pointer;
            border-radius: 5px;
            text-decoration: none;
        }
        .delete-btn:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
<?php @include 'admin_header.php'; ?>

    <div class="container">
        <h2>📩 Contact Messages</h2>

        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Message</th>
                <th>Date</th>
                <th>Action</th>
            </tr>

            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row["id"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["name"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["email"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["message"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["submitted_at"]) . "</td>";
                    echo "<td><a href='contect_message.php?id=" . $row["id"] . "' class='delete-btn' onclick='return confirm(\"Are you sure you want to delete this message?\")'>Delete</a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6' style='text-align: center;'>No messages found.</td></tr>";
            }
            ?>
        </table>
    </div>

</body>
</html>

<?php
// Close connection
$conn->close();
?>
