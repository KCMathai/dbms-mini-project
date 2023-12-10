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

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate input
    $username = sanitize_input($_POST["username"]);
    $password = sanitize_input($_POST["password"]);
    $role = sanitize_input($_POST["role"]);

    // Query to check user credentials
    $sql = "SELECT * FROM user WHERE username='$username' AND password='$password' AND role='$role'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // User found, store User_ID and Username in session
        $userDetails = $result->fetch_assoc();
        $_SESSION['user_id'] = $userDetails['User_ID'];
        $_SESSION['username'] = $userDetails['Username'];

        // Redirect based on role
        switch ($role) {
            case 'admin':
                header("Location: admin_page.html");
                break;
            case 'student':
                header("Location: student_page.php");
                break;
            case 'teacher':
                header("Location: teacher_page.php");
                break;
            // Add more cases for additional roles if needed
            default:
                echo "Invalid role";
                break;
        }
    } else {
        echo "Invalid credentials";
    }
}

$conn->close();

// Function to sanitize user input
function sanitize_input($input) {
    global $conn;
    return mysqli_real_escape_string($conn, trim($input));
}
?>
