<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
if (isset($_GET['attacker']) && isset($_GET['defender'])) {
    $attacker = $_GET['attacker'];
    $defender = $_GET['defender'];

	$conn = new mysqli("localhost", "elbkmjmy_WPGXP", "1#VghAm&}-.>uS)H=", "elbkmjmy_WPGXP");
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
$query = "SELECT * FROM attacks WHERE attacker = '$attacker' AND defender = '$defender'";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    // echo "Defender and Attacker already exist";
    while ($row = $result->fetch_assoc()) {
        if ($row['attacker_health'] > 0 && $row['defender_health'] > 0) {
            $attackerpoint = $row['attacker_points'] + 1;
            $randomNumber = mt_rand(1, 20);
            $randomNumber1 = $randomNumber + $attackerpoint;
            $randomNumber2 = mt_rand(1, 20);
            echo "The attacker number is: ".$randomNumber1;
            echo " The defender number is: ".$randomNumber2;
            echo " Your health has been paused for 2 hours.";
            $currenttime = time();
            $timestampAfter = strtotime('+1 second', $currenttime);
        	$formattedCurrentTime = date('Y-m-d H:i:s', $timestampAfter);
        	if($row['defender_last_updated'] !== null){
                $defendertime = $row['defender_last_updated'];
                $timestampAfter2 = strtotime($defendertime);
            	$formattedTimestamp = date('Y-m-d H:i:s', $timestampAfter2);
                if ($formattedCurrentTime > $formattedTimestamp) {
                    $updateQuery = "UPDATE attacks SET defender_health = 6 WHERE attacker = '$attacker' AND defender = '$defender'";
                    $conn->query($updateQuery);
                }
        	}
        	if($row['attacker_last_updated'] !== null){
        	    $attackertime = $row['attacker_last_updated'];
                $timestampAfter3 = strtotime($attackertime);
            	$formattedTimestamp2 = date('Y-m-d H:i:s', $timestampAfter3);
                if ($formattedCurrentTime > $formattedTimestamp2) {
                    $updateQuery = "UPDATE attacks SET attacker_health = 6 WHERE attacker = '$attacker' AND defender = '$defender'";
                    $conn->query($updateQuery);
                }
        	}
            $updateQuery = "UPDATE attacks SET attacker_number = '$randomNumber1', defender_number = '$randomNumber2', attacker_points = '$attackerpoint' WHERE attacker = '$attacker' AND defender = '$defender'";
            $conn->query($updateQuery);
            if($randomNumber1 < 5){
                $getattackerhealth  = $row['attacker_health'];
                $getattackerhealth -= 1;
                $timestampFromDatabase = time();
                $timestampAfter2Hours = strtotime('+2 hours', $timestampFromDatabase); 
                $formattedTimestamp = date('Y-m-d H:i:s', $timestampAfter2Hours);
                $updatehealth = "UPDATE attacks SET attacker_health = '$getattackerhealth', attacker_last_updated = '$formattedTimestamp' WHERE attacker = '$attacker' AND defender = '$defender'";
                $conn->query($updatehealth);
                echo " Attacker Lost the Attack due to low Attack!";
                // STEP 3 CALIING for attacker
            }
            elseif($randomNumber2 < 5){
                $getdefenderhealth  = $row['defender_health'];
                $getdefenderhealth -= 1;
                $timestampFromDatabase = time();
                $timestampAfter2Hours = strtotime('+2 hours', $timestampFromDatabase); 
                $formattedTimestamp = date('Y-m-d H:i:s', $timestampAfter2Hours);
                $updatehealth = "UPDATE attacks SET defender_health = '$getdefenderhealth', defender_last_updated = '$formattedTimestamp' WHERE attacker = '$attacker' AND defender = '$defender'";
                $conn->query($updatehealth);
                echo " Defender Lost due to low defence!";
                // STEP 3 CALIING for defender
            }
            else{
                if($randomNumber1 > $randomNumber2){
                $getdefenderhealth  = $row['defender_health'];
                $getdefenderhealth -= 1;
                $timestampFromDatabase = time();
                $timestampAfter2Hours = strtotime('+2 hours', $timestampFromDatabase); 
                $formattedTimestamp = date('Y-m-d H:i:s', $timestampAfter2Hours);
                $updatehealth = "UPDATE attacks SET defender_health = '$getdefenderhealth', defender_last_updated = '$formattedTimestamp' WHERE attacker = '$attacker' AND defender = '$defender'";
                $conn->query($updatehealth);
                    echo "  '$attacker' either hits or misses!";
                    // STEP 3 CALIING for defender
                }
                else{
                $getattackerhealth  = $row['attacker_health'];
                $getattackerhealth -= 1;
                $timestampFromDatabase = time();
                $timestampAfter2Hours = strtotime('+2 hours', $timestampFromDatabase); 
                $formattedTimestamp = date('Y-m-d H:i:s', $timestampAfter2Hours);
                $updatehealth = "UPDATE attacks SET attacker_health = '$getattackerhealth', attacker_last_updated = '$formattedTimestamp' WHERE attacker = '$attacker' AND defender = '$defender'";
                $conn->query($updatehealth);
                echo "  Attacker Lost the Attack due to low Attack!";
                    echo "  '$defender' won by greater defence";
                    // STEP 3 CALIING for attacker
                }
                
            }
            
        } else {
            echo " Player has no health!";
        }
    }
} else {
    // Row doesn't exist, insert a new row
    $insertQuery = "INSERT INTO attacks (attacker, defender, attacker_health, defender_health) VALUES ('$attacker', '$defender', 6, 6)";
    
    if ($conn->query($insertQuery) === TRUE) {
        $newRowId = $conn->insert_id;

    // SQL query to select the newly inserted row by its ID
    $selectQuery = "SELECT * FROM attacks WHERE id = $newRowId";
    $result = $conn->query($selectQuery);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $attackerpoint = $row['attacker_points'] + 1;
            $randomNumber = mt_rand(1, 20);
            $randomNumber1 = $randomNumber + $attackerpoint;
            $randomNumber2 = mt_rand(1, 20);
            echo "The attacker number is: ".$randomNumber1;
            echo " The defender number is: ".$randomNumber2;
            echo " Your health has been paused for 2 hours.";
            $currenttime = time();
            $timestampAfter = strtotime('+1 second', $currenttime);
        	$formattedCurrentTime = date('Y-m-d H:i:s', $timestampAfter);
        	if($row['defender_last_updated'] !== null){
                $defendertime = $row['defender_last_updated'];
                $timestampAfter2 = strtotime($defendertime);
            	$formattedTimestamp = date('Y-m-d H:i:s', $timestampAfter2);
                if ($formattedCurrentTime > $formattedTimestamp) {
                    $updateQuery = "UPDATE attacks SET defender_health = 6 WHERE attacker = '$attacker' AND defender = '$defender'";
                    $conn->query($updateQuery);
                }
        	}
        	if($row['attacker_last_updated'] !== null){
        	    $attackertime = $row['attacker_last_updated'];
                $timestampAfter3 = strtotime($attackertime);
            	$formattedTimestamp2 = date('Y-m-d H:i:s', $timestampAfter3);
                if ($formattedCurrentTime > $formattedTimestamp2) {
                    $updateQuery = "UPDATE attacks SET attacker_health = 6 WHERE attacker = '$attacker' AND defender = '$defender'";
                    $conn->query($updateQuery);
                }
        	}
            $updateQuery = "UPDATE attacks SET attacker_number = '$randomNumber1', defender_number = '$randomNumber2', attacker_points = '$attackerpoint' WHERE attacker = '$attacker' AND defender = '$defender'";
            $conn->query($updateQuery);
            if($randomNumber1 < 5){
                $getattackerhealth  = $row['attacker_health'];
                $getattackerhealth -= 1;
                $timestampFromDatabase = time();
                $timestampAfter2Hours = strtotime('+2 hours', $timestampFromDatabase); 
                $formattedTimestamp = date('Y-m-d H:i:s', $timestampAfter2Hours);
                $updatehealth = "UPDATE attacks SET attacker_health = '$getattackerhealth', attacker_last_updated = '$formattedTimestamp' WHERE attacker = '$attacker' AND defender = '$defender'";
                $conn->query($updatehealth);
                echo " Attacker Lost the Attack due to low Attack!";
                // STEP 3 CALIING for attacker
            }
            elseif($randomNumber2 < 5){
                $getdefenderhealth  = $row['defender_health'];
                $getdefenderhealth -= 1;
                $timestampFromDatabase = time();
                $timestampAfter2Hours = strtotime('+2 hours', $timestampFromDatabase); 
                $formattedTimestamp = date('Y-m-d H:i:s', $timestampAfter2Hours);
                $updatehealth = "UPDATE attacks SET defender_health = '$getdefenderhealth', defender_last_updated = '$formattedTimestamp' WHERE attacker = '$attacker' AND defender = '$defender'";
                $conn->query($updatehealth);
                echo " Defender Lost due to low defence!";
                // STEP 3 CALIING for defender
            }
            else{
                if($randomNumber1 > $randomNumber2){
                $getdefenderhealth  = $row['defender_health'];
                $getdefenderhealth -= 1;
                $timestampFromDatabase = time();
                $timestampAfter2Hours = strtotime('+2 hours', $timestampFromDatabase); 
                $formattedTimestamp = date('Y-m-d H:i:s', $timestampAfter2Hours);
                $updatehealth = "UPDATE attacks SET defender_health = '$getdefenderhealth', defender_last_updated = '$formattedTimestamp' WHERE attacker = '$attacker' AND defender = '$defender'";
                $conn->query($updatehealth);
                    echo " '$defender' either hits or misses!";
                    // STEP 3 CALIING for defender
                }
                else{
                $getattackerhealth  = $row['attacker_health'];
                $getattackerhealth -= 1;
                $timestampFromDatabase = time();
                $timestampAfter2Hours = strtotime('+2 hours', $timestampFromDatabase); 
                $formattedTimestamp = date('Y-m-d H:i:s', $timestampAfter2Hours);
                $updatehealth = "UPDATE attacks SET attacker_health = '$getattackerhealth', attacker_last_updated = '$formattedTimestamp' WHERE attacker = '$attacker' AND defender = '$defender'";
                $conn->query($updatehealth);
                echo " Attacker Lost the Attack due to low Attack!";
                    echo " '$attacker' won by greater defence";
                    // STEP 3 CALIING for attacker
                }
                
            }
            
        
    }
    }
    } else {
        echo " Error inserting new row: " . $conn->error;
    }
}

	$conn->close();
}
else{
    echo "Fail begin here!!!";
}
?>