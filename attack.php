<?php
if (isset($_GET['attacker']) && isset($_GET['defender'])) {
    $attacker = $_GET['attacker'];
    $defender = $_GET['defender'];

	$conn = new mysqli("localhost", "elbkmjmy_WPGXP", "1#VghAm&}-.>uS)H=", "elbkmjmy_WPGXP");
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}

	$sql = "INSERT INTO attacks (attacker, defender) VALUES ('$attacker', '$defender')";
	if ($conn->query($sql) === TRUE) {
		echo "Attack data stored successfully.";
		echo 'The attacker is: '.$attacker.' and the defender is: '.$defender;
	} else {
		echo "Error: " . $sql . "<br>" . $conn->error;
	}

	$conn->close();
    
    echo "Players' data stored.";
}
else{
    echo "Fail begin here!!!";
}
?>