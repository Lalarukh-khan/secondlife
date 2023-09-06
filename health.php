<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
if (isset($_GET['healer']) && isset($_GET['player'])) {
    $attacker_lsl = $_GET['healer'];
    $defender_lsl = $_GET['player'];
    $attacker = "";
    $defender = "";
    if($attacker_lsl == "Lalarukh Resident"){
        $attacker = $attacker_lsl;
        $defender = $defender_lsl;
    }
    elseif($attacker_lsl == "Ember Ronas"){
        $attacker = $defender_lsl;
        $defender = $attacker_lsl;
    }
    else{
        $attacker = $attacker_lsl;
        $defender = $defender_lsl;
    }

	$conn = new mysqli("localhost", "elbkmjmy_WPGXP", "1#VghAm&}-.>uS)H=", "elbkmjmy_WPGXP");
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}

$query = "SELECT * FROM attacks WHERE attacker = '$attacker' AND defender = '$defender'";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    // echo "Defender and Attacker already exist";
    while ($row = $result->fetch_assoc()) {
            $attackerpoint = $row['healer_points'] + 1;
            $randomNumber = mt_rand(1, 20);
            $randomNumber2 = "";
            $randomNumber1 =  $randomNumber + $attackerpoint;
            $currenttime = time();
            $timestampAfter = strtotime('+1 second', $currenttime);
        	$attackertime = $row['heal_last_updated'];
            $timestampAfter3 = strtotime($attackertime);
            $formattedTimestamp2 = date('Y-m-d H:i:s', $timestampAfter3);
        	$formattedCurrentTime = date('Y-m-d H:i:s', $timestampAfter);
            $ishealthpause = false;
            $pausetime = "";
            $pausetimetoshow = "";
            if ($formattedCurrentTime > $formattedTimestamp2) {
                $pausetime = '+30 minutes';
                $pausetimetoshow = '30 minutes';
                $randomNumber2 = 5;
            }
            else{
                $ishealthpause = true;
                $pausetime = '+90 minutes';
                $pausetimetoshow = '90 minutes';
                $randomNumber2 = 10;
            }
            if($randomNumber1 > 20){
                $randomNumber1 = 20;
            }
            echo "The Healer number is: ".$randomNumber1 . ". ";
            echo " Your health has been paused for $pausetimetoshow.";
            $updateQuery = "UPDATE attacks SET healer_number = '$randomNumber1', defender_number = '$randomNumber2', healer_points = '$attackerpoint' WHERE attacker = '$attacker' AND defender = '$defender'";
            $conn->query($updateQuery);
                if($randomNumber1 > $randomNumber2){
                $getdefenderhealth  = $row['defender_health'];
                $getdefenderhealth += 1;
                $timestampFromDatabase = time();
                $timestampAfter2Hours = strtotime($pausetime, $timestampFromDatabase); 
                $formattedTimestamp = date('Y-m-d H:i:s', $timestampAfter2Hours);
                $updatehealth = "UPDATE attacks SET defender_health = '$getdefenderhealth', heal_last_updated = '$formattedTimestamp' WHERE attacker = '$attacker' AND defender = '$defender'";
                $conn->query($updatehealth);
                    echo "  '$attacker' has been won and healed! '$defender' got 1 point of health. ";
                }
                else{
                    // STEP 3 CALIING for defender
                    $maxTrials = 3;
                    $secondIsLarger = false;
                    for ($trial = 1; $trial <= $maxTrials; $trial++) {
                        if($trial == 1){
                            echo " '$attacker' has been offered for RE-ROLL. ";
                        }
                        else{
                            echo " Again '$attacker' has been offered for RE-ROLL. ";
                        }
                        $newrandomNumber = mt_rand(1, 20);
                        echo " Generating healer for player in '$trial' reroll. the healer new number is: '$newrandomNumber' ";
                        if ($newrandomNumber > $randomNumber2) {
                            $secondIsLarger = true;
                            $updateattcknmb = "UPDATE attacks SET healer_number = '$newrandomNumber'  WHERE attacker = '$attacker' AND defender = '$defender'";
                            $conn->query($updateattcknmb);
                            break; // Terminate the loop
                        }
                        else{
                            echo " Player again lost the by low heal in '$trial' reroll! ";
                        }
                    }
                    if ($secondIsLarger) {
                        echo " Finally! '$attacker' has been succcessfully won in the $trial Re-Roll. '$defender' got 1 point of health. ";
                        $timestampFromDatabase = time();
                        $timestampAfter2Hours = strtotime($pausetime, $timestampFromDatabase); 
                        $formattedTimestamp = date('Y-m-d H:i:s', $timestampAfter2Hours);
                        $updatehealth = "UPDATE attacks SET heal_last_updated = '$formattedTimestamp' WHERE attacker = '$attacker' AND defender = '$defender'";
                    } else {
                        echo " In all Re-Rolls the '$attacker' couldn't win the heal.";
                        $timestampFromDatabase = time();
                        $timestampAfter2Hours = strtotime($pausetime, $timestampFromDatabase); 
                        $formattedTimestamp = date('Y-m-d H:i:s', $timestampAfter2Hours);
                        $updatehealth = "UPDATE attacks SET heal_last_updated = '$formattedTimestamp' WHERE attacker = '$attacker' AND defender = '$defender'";
                    }
                
                }
            
        }
} else {
    // Row doesn't exist, insert a new row
    $insertQuery = "INSERT INTO attacks (attacker, defender) VALUES ('$attacker', '$defender')";
    
    if ($conn->query($insertQuery) === TRUE) {
        $newRowId = $conn->insert_id;

    // SQL query to select the newly inserted row by its ID
    $selectQuery = "SELECT * FROM attacks WHERE id = $newRowId";
    $result = $conn->query($selectQuery);
    if ($result->num_rows > 0) {
       while ($row = $result->fetch_assoc()) {
            $attackerpoint = $row['healer_points'] + 1;
            $randomNumber = mt_rand(1, 20);
            $randomNumber1 =  $randomNumber + $attackerpoint;
            $ishealthpause = true;
            $pausetimetoshow = "";
                $pausetime = '+30 minutes';
                $pausetimetoshow = '30 minutes';
                $randomNumber2 = 5;
            if($randomNumber1 > 20){
                $randomNumber1 = 20;
            }
            echo "The Healer number is: ".$randomNumber1 . ". ";
            echo " Your health has been paused for $pausetimetoshow.";
            $updateQuery = "UPDATE attacks SET healer_number = '$randomNumber1', defender_number = '$randomNumber2', healer_points = '$attackerpoint' WHERE attacker = '$attacker' AND defender = '$defender'";
            $conn->query($updateQuery);
                if($randomNumber1 > $randomNumber2){
                $getdefenderhealth  = $row['defender_health'];
                $getdefenderhealth += 1;
                $timestampFromDatabase = time();
                $timestampAfter2Hours = strtotime($pausetime, $timestampFromDatabase); 
                $formattedTimestamp = date('Y-m-d H:i:s', $timestampAfter2Hours);
                $updatehealth = "UPDATE attacks SET defender_health = '$getdefenderhealth', heal_last_updated = '$formattedTimestamp' WHERE attacker = '$attacker' AND defender = '$defender'";
                $conn->query($updatehealth);
                    echo "  '$attacker' has been won and healed! '$defender' got 1 point of health. ";
                }
                else{
                    // STEP 3 CALIING for defender
                    $maxTrials = 3;
                    $secondIsLarger = false;
                    for ($trial = 1; $trial <= $maxTrials; $trial++) {
                        if($trial == 1){
                            echo " '$attacker' has been offered for RE-ROLL. ";
                        }
                        else{
                            echo " Again '$attacker' has been offered for RE-ROLL. ";
                        }
                        $newrandomNumber = mt_rand(1, 20);
                        echo " Generating healer for player in '$trial' reroll. the healer new number is: '$newrandomNumber' ";
                        if ($newrandomNumber > $randomNumber2) {
                            $secondIsLarger = true;
                            $updateattcknmb = "UPDATE attacks SET healer_number = '$newrandomNumber'  WHERE attacker = '$attacker' AND defender = '$defender'";
                            $conn->query($updateattcknmb);
                            break; // Terminate the loop
                        }
                        else{
                            echo " Player again lost the by low heal in '$trial' reroll! ";
                        }
                    }
                    if ($secondIsLarger) {
                        echo " Finally! '$attacker' has been succcessfully won in the $trial Re-Roll. '$defender' got 1 point of health. ";
                        $timestampFromDatabase = time();
                        $timestampAfter2Hours = strtotime($pausetime, $timestampFromDatabase); 
                        $formattedTimestamp = date('Y-m-d H:i:s', $timestampAfter2Hours);
                        $updatehealth = "UPDATE attacks SET heal_last_updated = '$formattedTimestamp' WHERE attacker = '$attacker' AND defender = '$defender'";
                    } else {
                        echo " In all Re-Rolls the '$attacker' couldn't win the heal.";
                        $timestampFromDatabase = time();
                        $timestampAfter2Hours = strtotime($pausetime, $timestampFromDatabase); 
                        $formattedTimestamp = date('Y-m-d H:i:s', $timestampAfter2Hours);
                        $updatehealth = "UPDATE attacks SET heal_last_updated = '$formattedTimestamp' WHERE attacker = '$attacker' AND defender = '$defender'";
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