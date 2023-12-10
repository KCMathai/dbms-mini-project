<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Students</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 20px;
        }

        table {
            width: 80%;
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

<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "kevin";
$dbname = "university_management";

// Start a session
session_start();

// Check if the session variable is set
if (isset($_SESSION['user_id'])) {
    // Get the User_ID from the session
    $userID = $_SESSION['user_id'];

    // Create a connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Query to get teacher students based on User_ID
    $sqlGetTeacherStudents = "SELECT s.Student_ID, s.Student_Name, s.Email_Address
                              FROM student s
                              JOIN faculty t ON s.Department_ID = t.Department_ID
                              WHERE t.User_ID = '$userID'";

    $resultTeacherStudents = $conn->query($sqlGetTeacherStudents);

    if ($resultTeacherStudents->num_rows > 0) {
        // Output teacher students in table format
        echo "<h2>Students</h2>";
        echo "<table>";
        echo "<tr><th>Student ID</th><th>Student Name</th><th>Email Address</th></tr>";

        while ($row = $resultTeacherStudents->fetch_assoc()) {
            echo "<tr><td>{$row['Student_ID']}</td><td>{$row['Student_Name']}</td><td>{$row['Email_Address']}</td></tr>";
        }

        echo "</table>";
    } else {
        echo "No students found for the teacher.";
    }

    $conn->close();
} else {
    echo "User not logged in.";
}
?>
</body>
</html>
