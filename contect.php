<?php
session_start();

// Database Connection
$host = "localhost";  
$user = "root";       
$password = "";       
$dbname = "learning"; 

$conn = mysqli_connect($host, $user, $password, $dbname);

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

if (!isset($_SESSION['email'])) {
    header("location: main.php");
    exit();
}

$messageSent = false;
$errorMsg = "";

// Handle Form Submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim(htmlspecialchars($_POST['name']));
    $email = trim(htmlspecialchars($_POST['email']));
    $message = trim(htmlspecialchars($_POST['message']));

    if (!empty($name) && !empty($email) && !empty($message)) {
        // Use prepared statement to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO contact_messages (name, email, message) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $message);

        if ($stmt->execute()) {
            $messageSent = true;
        } else {
            $errorMsg = "Error saving message. Please try again.";
        }
        $stmt->close();
    } else {
        $errorMsg = "Please fill in all fields.";
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f8f8;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 50%;
            margin: 3% auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        h2 {
            color: #333;
            font-size: 28px;
            margin-bottom: 20px;
        }
        label {
            font-weight: bold;
            display: block;
            margin: 10px 15px;
            text-align: left;
        }
        input, textarea {
            width: 95%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .btn {
            background-color: #28a745;
            color: white;
            border: none;
            width: 50%;
            padding: 12px;
            margin-top: 15px;
            cursor: pointer;
            border-radius: 5px;
            font-size: 16px;
        }
        .btn:hover {
            background-color: #218838;
        }
        .info {
            border-top: 2px solid black;
            margin-top: 30px;
            font-size: 16px;
            padding-top: 10px;
        }
        .success, .error {
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            text-align: center;
        }
        .success {
            background-color: #d4edda;
            color: #155724;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
        }
        @media (max-width: 768px) {
            .container {
                width: 90%;
            }
            .btn {
                width: 70%;
            }
        }
    </style>
</head>
<body>

    <?php @include 'header.php'; ?>

    <div class="container">
        <h2>📞 Contact Us</h2>

        <!-- Display Success or Error Message with Auto Hide -->
        <?php if ($messageSent): ?>
            <div class="success" id="messageBox">Your message has been saved successfully!</div>
        <?php elseif (!empty($errorMsg)): ?>
            <div class="error" id="messageBox"><?= $errorMsg; ?></div>
        <?php endif; ?>

        <form action="" method="POST">
            <label>Name:</label>
            <input type="text" name="name" placeholder="Enter your Name" required>

            <label>Email:</label>
            <input type="email" name="email" placeholder="Enter Your Email" required>

            <label>Message:</label>
            <textarea name="message" placeholder="Write your message here..." rows="4" required></textarea>

            <button type="submit" class="btn">Send</button>
        </form>

        <div class="info">
            <p>📱 Call: +91 97944 42828 or +91 83693 91516</p>
            <p>📩 Email: roshanpraajapti7064@gmail.com or rushikeshtawale@gmail.com</p>
            <p>🏠 Address: Mahadev Collection , Indira Nagar, Road No. 22, Thane (400604), Maharashtra, India</p>
        </div>
    </div>

    <!-- JavaScript to Hide Message After 5 Seconds -->
    <script>
        setTimeout(function() {
            var messageBox = document.getElementById("messageBox");
            if (messageBox) {
                messageBox.style.display = "none";
            }
        }, 5000); // Hide after 5 seconds (5000ms)
    </script>

</body>
</html>
