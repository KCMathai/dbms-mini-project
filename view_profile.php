<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 20px;
        }

        table {
            width: 50%;
            margin: 20px auto;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #3498db;
            color: #fff;
        }
    </style>
</head>
<body>

<h2>Profile</h2>
<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "kevin";
$dbname = "university_management";

// Start a session
session_start();

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the session variable is set
if (isset($_SESSION['user_id'])) {
    // Get the User_ID from the session
    $userID = $_SESSION['user_id'];

    // Query to get user details based on User_ID
    $sqlGetUserDetails = "SELECT * FROM user WHERE User_ID='$userID'";
    $resultUserDetails = $conn->query($sqlGetUserDetails);

    if ($resultUserDetails->num_rows > 0) {
        // Fetch user details
        $userDetails = $resultUserDetails->fetch_assoc();

        // Output user details in table format
        echo "<table>";
        echo "<tr><th>Attribute</th><th>Value</th></tr>";
        foreach ($userDetails as $attribute => $value) {
            echo "<tr><td>$attribute</td><td>$value</td></tr>";
        }
        echo "</table>";
    } else {
        echo "User not found.";
    }
} else {
    echo "User not logged in.";
}

$conn->close();
?>
</body>
</html>
