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
    $teacherName = sanitize_input($_POST["teacherName"]);
    $emailAddress = sanitize_input($_POST["emailAddress"]);
    $departmentID = sanitize_input($_POST["departmentID"]);
    $userID = sanitize_input($_POST["userID"]);

    // Get the maximum Teacher_ID from the faculty table
    $sqlMaxID = "SELECT MAX(Faculty_ID) as max_id FROM faculty";
    $resultMaxID = $conn->query($sqlMaxID);

    if ($resultMaxID && $rowMaxID = $resultMaxID->fetch_assoc()) {
        // Increment the maximum Teacher_ID by 1
        $newTeacherID = $rowMaxID['max_id'] + 1;

        // Insert the new teacher into the faculty table
        $sqlInsert = "INSERT INTO faculty (Faculty_ID, Faculty_Name, Email_Address, Department_ID, User_ID)
                      VALUES ($newTeacherID, '$teacherName', '$emailAddress', '$departmentID', '$userID')";

        if ($conn->query($sqlInsert) === TRUE) {
            echo "Teacher added successfully with Faculty_ID: $newTeacherID";
        } else {
            echo "Error adding teacher: " . $conn->error;
        }
    } else {
        echo "Error retrieving maximum Faculty_ID";
    }
}

$conn->close();

// Function to sanitize user input
function sanitize_input($input) {
    global $conn;
    return mysqli_real_escape_string($conn, trim($input));
}
?>
