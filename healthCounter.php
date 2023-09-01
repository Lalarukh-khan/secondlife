<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "mysql";
$dbname = "secondlife";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Button was clicked, decrement the value by 1
    $sql = "UPDATE number_state SET number = number - 1";
    $conn->query($sql);

    // Start a timer for 1 minute (60 seconds)
    sleep(60);

    // Increment the value by 1
    $sql = "UPDATE number_state SET number = number + 1";
    $conn->query($sql);
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Button Example</title>
</head>
<body>
    <form method="post">
        <input type="submit" value="Click to Decrease Number">
    </form>
</body>
</html>
