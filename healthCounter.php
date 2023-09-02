<?php
// Database connection parameters
$host = 'localhost';
$username = 'root';
$password = 'mysql';
$database = 'secondlife';

// Create a database connection
$conn = new mysqli($host, $username, $password, $database);

// Check if the connection was successful
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}
echo "HELOOOOOOO <br>";
// Define the time interval in seconds (1 minute)
$interval = 60; // 1 minute

$timestampFromDatabase1 = time(); // Get the current timestamp
$timestampAfter2Hours = strtotime('+2 hours', $timestampFromDatabase1); // Add 2 hours

// Format the new timestamp as needed (e.g., "Y-m-d H:i:s")
$formattedTimestamp = date('Y-m-d H:i:s', $timestampAfter2Hours);

echo "Final time : ". $formattedTimestamp;
// Retrieve the current state of the number and last updated timestamp
$query = "SELECT number, last_updated FROM number_state";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $number = $row['number'];
	$timestamp = strtotime($row['last_updated']);
	$dbTime = strtotime($row['last_updated']); // Convert the database time to a timestamp
    
    // Get the current time as a timestamp
    $currentTime = time();
	$formattedTimestamp = date('Y-m-d H:i:s', $dbTime);
	$formattedCurrentTime = date('Y-m-d H:i:s', $currentTime);
    echo "currentTime : ".$formattedCurrentTime;
    echo "dbTime : ".$formattedTimestamp;
    // Check if the current time is ahead of the database time
    if ($currentTime > $dbTime) {
        echo "Current time is ahead of the database time.";
    } else {
        echo "Current time is not ahead of the database time.";
    }

    // $currentTime = time();
	// // $timestamp = strtotime($row['last_updated']);
	// $timestamp = strtotime($row['last_updated']);

	// if ($timestamp && getTimeDifference($timestamp) >= 60) {
	// 	echo "Current time is 1 minute or more ahead of the timestamp.";
	// }else {
    //     echo "Less than 1 minute has passed since the stored timestamp.";
    // }
    // Check if it's been more than 1 minute since the last update
    // if (time() - $lastUpdated >= $interval) {
    //     // It's been more than 1 minute, so increment the number by 1
    //     $number += 1;

    //     // Update the database with the new number and current timestamp
    //     $updateQuery = "UPDATE number_state SET number = 6, last_updated = NOW()";
    //     $conn->query($updateQuery);
    // }
}

function getTimeDifference($timestamp) {
	$currentTimestamp = time();
	return ($currentTimestamp - $timestamp) / 60; // Return the difference in minutes
}

// Check if the button was clicked
if (isset($_POST['button_clicked'])) {
    // Decrease the number by 1
    $number -= 1;

    // Update the database with the new number and current timestamp
	
	$query = "SELECT last_updated FROM number_state"; // Add your condition here
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $timestampFromDatabase = strtotime($row['last_updated']);
		$newTimestamp = date('Y-m-d H:i:s', strtotime('+1 minute', $timestampFromDatabase));
        
        // Update the database with the new timestamp
        $updateQuery = "UPDATE number_state SET last_updated = '$newTimestamp'"; // Add your condition here
        $conn->query($updateQuery);
        
        echo "1 minute added to the timestamp_column.";
    } else {
        echo "No matching rows found.";
    }

    // $updateQuery = "UPDATE number_state SET number = 6, last_updated = NOW()";
    // $conn->query($updateQuery);
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Number Update</title>
</head>
<body>
    <h1>Current Number: <?php echo $number; ?></h1>
    <form method="post">
        <input type="submit" name="button_clicked" value="Decrease Number">
    </form>
</body>
</html>
