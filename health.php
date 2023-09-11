<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
if (isset($_GET['player'])) {
    $player = $_GET['player'];
    
    $conn = new mysqli("localhost", "elbkmjmy_WPGXP", "1#VghAm&}-.>uS)H=", "elbkmjmy_WPGXP");
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	
	$query = "SELECT * FROM attacks WHERE attacker = '$player'";
    $result = $conn->query($query);
    $dquery = "SELECT * FROM attacks WHERE defender = '$defender'";
    $dresult = $conn->query($dquery);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "Profile Found in attacker!";
            echo "Player current health is: ".$row['attacker_health'];
        }
    }
    elseif ($dresult->num_rows > 0) {
        while ($row = $dresult->fetch_assoc()) {
            echo "Profile Found in defender!";
            echo "Player current health is: ".$row['defender_health'];
        }
    }
    else{
        echo "No profile found for this player name: $player";
    }
}
?>