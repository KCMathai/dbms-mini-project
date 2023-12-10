<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "kevin";
$dbname = "university_management";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate input
    $studentName = sanitize_input($_POST["studentName"]);
    $emailAddress = sanitize_input($_POST["emailAddress"]);
    $departmentID = sanitize_input($_POST["departmentID"]);
    $userID = sanitize_input($_POST["userID"]);

    // Get the maximum Student_ID from the students table
    $sqlMaxID = "SELECT MAX(Student_ID) as max_id FROM student";
    $resultMaxID = $conn->query($sqlMaxID);

    if ($resultMaxID && $rowMaxID = $resultMaxID->fetch_assoc()) {
        // Increment the maximum Student_ID by 1
        $newStudentID = $rowMaxID['max_id'] + 1;

        // Insert the new student into the students table
        $sqlInsert = "INSERT INTO student (Student_ID, Student_Name, Email_Address, Department_ID, User_ID)
                      VALUES ($newStudentID, '$studentName', '$emailAddress', '$departmentID', '$userID')";

        if ($conn->query($sqlInsert) === TRUE) {
            echo "Student added successfully with Student_ID: $newStudentID";
        } else {
            echo "Error adding student: " . $conn->error;
        }
    } else {
        echo "Error retrieving maximum Student_ID";
    }
}

$conn->close();

// Function to sanitize user input
function sanitize_input($input) {
    global $conn;
    return mysqli_real_escape_string($conn, trim($input));
}
?>
