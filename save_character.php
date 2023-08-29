<?php
// Establish database connection
$dbHost = 'localhost';
$dbUser = 'root';
$dbPass = 'mysql';
$dbName = 'secondlife';
$conn = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName);

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Process form data
$avatarName = $_POST['avatarName'];
$appearance = $_POST['appearance'];
$clothing = $_POST['clothing'];

// Insert data into database
$query = "INSERT INTO character_data (avatarName, appearance, clothing) VALUES ('$avatarName', '$appearance', '$clothing')";
$result = mysqli_query($conn, $query);

if ($result) {
    echo "Character created successfully!";
} else {
    echo "Error creating character: " . mysqli_error($conn);
}

// Close database connection
mysqli_close($conn);
?>