<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Students</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 20px;
        }

        h2 {
            color: #3498db;
        }

        table {
            border-collapse: collapse;
            width: 80%;
            margin: 20px auto;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

    <h2>Students Table</h2>

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

    // Query to select data from the students table
    $sql = "SELECT Student_ID, Student_Name, Email_Address, Department_ID, User_ID FROM student";
    $result = $conn->query($sql);

    // Check if there are rows in the result
    if ($result->num_rows > 0) {
        echo "<table>
                <tr>
                    <th>Student ID</th>
                    <th>Student Name</th>
                    <th>Email Address</th>
                    <th>Department ID</th>
                    <th>User ID</th>
                </tr>";

        // Output data of each row
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['Student_ID']}</td>
                    <td>{$row['Student_Name']}</td>
                    <td>{$row['Email_Address']}</td>
                    <td>{$row['Department_ID']}</td>
                    <td>{$row['User_ID']}</td>
                  </tr>";
        }

        echo "</table>";
    } else {
        echo "No students found in the database.";
    }

    $conn->close();
    ?>

</body>
</html>
