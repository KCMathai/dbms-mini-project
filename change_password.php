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

session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate input
    $userID = $_SESSION['user_id'];
    $currentPassword = sanitize_input($_POST["currentPassword"]);
    $newPassword = sanitize_input($_POST["newPassword"]);
    $confirmPassword = sanitize_input($_POST["confirmPassword"]);

    // Check if the new password and confirm password match
    if ($newPassword != $confirmPassword) {
        echo "New password and confirm password do not match.";
    } else {
        // Query to check current user credentials
        $sqlCheckUser = "SELECT * FROM user WHERE User_ID='$userID' AND Password='$currentPassword'";
        $resultCheckUser = $conn->query($sqlCheckUser);

        if ($resultCheckUser->num_rows > 0) {
            // Update the password
            $sqlUpdatePassword = "UPDATE user SET Password='$newPassword' WHERE User_ID='$userID'";
            
            if ($conn->query($sqlUpdatePassword) === TRUE) {
                echo "Password changed successfully!";
            } else {
                echo "Error updating password: " . $conn->error;
            }
        } else {
            echo "Invalid current password.";
        }
    }
}

$conn->close();

// Function to sanitize user input
function sanitize_input($input) {
    global $conn;
    return mysqli_real_escape_string($conn, trim($input));
}
?>
