<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['attacker']) && isset($_POST['defender'])) {
    $servername = "localhost";
	$username = "elbkmjmy_WPGXP";
	$password = "1#VghAm&}-.>uS)H=";
	$dbname = "elbkmjmy_WPGXP";
	// Retrieve the attacker and defender names from the request
	$attacker = $_POST['attacker'];
	$defender = $_POST['defender'];

	// Store the attacker and defender names in the database
	$conn = new mysqli($servername, $username, $password, $dbname);
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}

	$sql = "INSERT INTO attacks (attacker, defender) VALUES ('$attacker', '$defender')";
	if ($conn->query($sql) === TRUE) {
		echo "Attack data stored successfully.";

		// Send response back to Second Life
		echo "Healing will be paused for the next 2 hours.";
	} else {
		echo "Error: " . $sql . "<br>" . $conn->error;
	}

	$conn->close();
}

?>



<?php
if (isset($_POST['attacker']) && isset($_POST['defender'])) {
    $attacker = $_POST['attacker'];
    $defender = $_POST['defender'];

	$conn = new mysqli("localhost", "elbkmjmy_WPGXP", "1#VghAm&}-.>uS)H=", "elbkmjmy_WPGXP");
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}

	$sql = "INSERT INTO attacks (attacker, defender) VALUES ('$attacker', '$defender')";
	if ($conn->query($sql) === TRUE) {
		echo "Attack data stored successfully.";

		// Send response back to Second Life
		echo "Healing will be paused for the next 2 hours.";
	} else {
		echo "Error: " . $sql . "<br>" . $conn->error;
	}

	$conn->close();
    
    echo "Players' data stored.";
}
?>