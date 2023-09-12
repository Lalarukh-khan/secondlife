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
            echo " Profile found to check health! "; 
            $health = $row['attacker_health']; 
            echo " Before checking your current stored health is: '$health'. ";
            $currentTime = time();
            $dbTime = strtotime($row['attacker_last_updated']);
            $timeDifferenceInSeconds = $currentTime - $dbTime;
            if ($timeDifferenceInSeconds >= 1800 && $timeDifferenceInSeconds < 5400) {
                if($health < 6){
                    $health += 1;
                    echo " 1 point of health has been regenerated. As '30 minutes' has been passed away. ";
                    $updateQuery = "UPDATE attacks SET attacker_health = '$health' WHERE attacker = '$player'";
                    $conn->query($updateQuery);
                    echo " Your current health is: '$health'. ";
                }
                else{
                    echo " Your health is already full. You have '$health' points of health. ";
                }
            }
            elseif ($timeDifferenceInSeconds >= 5400 && $timeDifferenceInSeconds < 10800) {
                if($health < 6){
                    $health += 2;
                    echo " 2 points of health has been regenerated. As '1 hour' has been passed away. ";
                    if($health > 6){
                        $health = 6;
                    }
                    $updateQuery = "UPDATE attacks SET attacker_health = '$health' WHERE attacker = '$player'";
                    $conn->query($updateQuery);
                    echo " Your current health is: '$health'. ";
                }
                else{
                    echo " Your health is already full. You have '$health' points of health. ";
                }
            }
            elseif ($timeDifferenceInSeconds >= 10800 && $timeDifferenceInSeconds < 18000) {
                if($health < 6){
                    $health += 3;
                    echo " 3 points of health has been regenerated. As '3 hours' has been passed away. ";
                    if($health > 6){
                        $health = 6;
                    }
                    $updateQuery = "UPDATE attacks SET attacker_health = '$health' WHERE attacker = '$player'";
                    $conn->query($updateQuery);
                    echo " Your current health is: '$health'. ";
                }
                else{
                    echo " Your health is already full. You have '$health' points of health. ";
                }
            }
            elseif ($timeDifferenceInSeconds >= 18000 && $timeDifferenceInSeconds < 25200) {
                if($health < 6){
                    $health += 4;
                    echo " 4 points of health has been regenerated. As '5 hours' has been passed away. ";
                    if($health > 6){
                        $health = 6;
                    }
                    $updateQuery = "UPDATE attacks SET attacker_health = '$health' WHERE attacker = '$player'";
                    $conn->query($updateQuery);
                    echo " Your current health is: '$health'. ";
                }
                else{
                    echo " Your health is already full. You have '$health' points of health. ";
                }
            }
            elseif ($timeDifferenceInSeconds >= 25200 && $timeDifferenceInSeconds < 28800) {
                if($health < 6){
                    $health += 5;
                    echo " 5 points of health has been regenerated. As '7 hours' has been passed away. ";
                    if($health > 6){
                        $health = 6;
                    }
                    $updateQuery = "UPDATE attacks SET attacker_health = '$health' WHERE attacker = '$player'";
                    $conn->query($updateQuery);
                    echo " Your current health is: '$health'. ";
                }
                else{
                    echo " Your health is already full. You have '$health' points of health. ";
                }
            }
            elseif ($timeDifferenceInSeconds >= 28800) {
                if($health < 6){
                    $health = 6;
                    echo " 6 points of health has been regenerated. As '8 hours' has been passed away. Now your complete health is regenerated. ";
                    $updateQuery = "UPDATE attacks SET attacker_health = '$health' WHERE attacker = '$player'";
                    $conn->query($updateQuery);
                    echo " Your current health is: '$health'. ";
                }
                else{
                    echo " Your health is already full. You have '$health' points of health. ";
                }
            } else {
                echo " Your health can not be regeneted, as its still paused due to less time. After 30 mins, your health will begin regenerating. ";
            }
        }
    }
    // elseif ($dresult->num_rows > 0) {
    //     while ($row = $dresult->fetch_assoc()) {
    //         echo "Profile Found as defender!";
    //         echo "Player current health is: ".$row['defender_health'];
    //     }
    // }
    else{
        echo " No profile found for this player name: $player ";
    }
}
?>