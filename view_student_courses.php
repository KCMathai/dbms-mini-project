<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Courses</title>
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

    // Query to get student courses based on User_ID
    $sqlGetStudentCourses = "SELECT c.Course_ID, c.Course_Name, c.Credit_Hour
                             FROM course c
                             JOIN student s ON c.Department_ID = s.Department_ID
                             WHERE s.User_ID = '$userID'";

    $resultStudentCourses = $conn->query($sqlGetStudentCourses);

    if ($resultStudentCourses->num_rows > 0) {
        // Output student courses in table format
        echo "<h2>Student Courses</h2>";
        echo "<table>";
        echo "<tr><th>Course ID</th><th>Course Name</th><th>Credit Hour</th></tr>";

        while ($row = $resultStudentCourses->fetch_assoc()) {
            echo "<tr><td>{$row['Course_ID']}</td><td>{$row['Course_Name']}</td><td>{$row['Credit_Hour']}</td></tr>";
        }

        echo "</table>";
    } else {
        echo "No courses found for the student.";
    }

    $conn->close();
} else {
    echo "User not logged in.";
}
?>
</body>
</html>
