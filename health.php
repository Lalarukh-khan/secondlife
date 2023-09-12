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
    // $dquery = "SELECT * FROM attacks WHERE defender = '$player'";
    // $dresult = $conn->query($dquery);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "Profile Found as attacker!";
            $dbTime = strtotime($row['attacker_last_updated']); 
            $currentTime = time();
            echo "current time: ".$currentTime;
            echo "Attacker time: ".$dbTime;
            $timeDifferenceInSeconds = $currentTime - $dbTime;
            if ($timeDifferenceInSeconds >= 1800 && $timeDifferenceInSeconds < 5400) {
                echo "Current time is 30 minutes ahead of DB time.";
            }
            elseif ($timeDifferenceInSeconds >= 5400 && $timeDifferenceInSeconds < 10800) {
                echo "Current time is 1 hour and 30 mins ahead of DB time.";
            }
            elseif ($timeDifferenceInSeconds >= 10800 && $timeDifferenceInSeconds < 18000) {
                echo "Current time is 3 hours ahead of DB time.";
            }
            elseif ($timeDifferenceInSeconds >= 18000 && $timeDifferenceInSeconds < 25200) {
                echo "Current time is 5 hours ahead of DB time.";
            }
            elseif ($timeDifferenceInSeconds >= 25200 && $timeDifferenceInSeconds < 28800) {
                echo "Current time is 7 hours ahead of DB time.";
            }
            elseif ($timeDifferenceInSeconds >= 28800) {
                echo "Current time is 8 hours ahead of DB time.";
            } else {
                echo "Current time is not 30 minutes, 2 hours, or 3 hours ahead of DB time.";
            }
            echo "Player current health is: ".$row['attacker_health'];
        }
    }
    // elseif ($dresult->num_rows > 0) {
    //     while ($row = $dresult->fetch_assoc()) {
    //         echo "Profile Found as defender!";
    //         echo "Player current health is: ".$row['defender_health'];
    //     }
    // }
    else{
        echo "No profile found for this player name: $player";
    }
}
?>