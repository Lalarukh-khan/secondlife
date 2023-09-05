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

$query = "SELECT * FROM heals WHERE attacker = '$attacker' AND defender = '$defender'";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    // echo "Defender and Attacker already exist";
    while ($row = $result->fetch_assoc()) {
            $attackerpoint = $row['attacker_points'] + 1;
            $randomNumber = mt_rand(10, 20);
            $randomNumber1 = $randomNumber + $attackerpoint;
            $randomNumber2 = mt_rand(10, 20);
            echo "The Healer number is: ".$randomNumber1;
            echo " The Player number is: ".$randomNumber2;
            echo " Your health has been paused for 90 minutes.";
            $currenttime = time();
            $timestampAfter = strtotime('+1 second', $currenttime);
        	$formattedCurrentTime = date('Y-m-d H:i:s', $timestampAfter);
        	if($row['defender_last_updated'] !== null){
                $defendertime = $row['defender_last_updated'];
                $timestampAfter2 = strtotime($defendertime);
            	$formattedTimestamp = date('Y-m-d H:i:s', $timestampAfter2);
                if ($formattedCurrentTime > $formattedTimestamp) {
                    $updateQuery = "UPDATE heals SET defender_health = 0 WHERE attacker = '$attacker' AND defender = '$defender'";
                    $conn->query($updateQuery);
                }
        	}
        	if($row['attacker_last_updated'] !== null){
        	    $attackertime = $row['attacker_last_updated'];
                $timestampAfter3 = strtotime($attackertime);
            	$formattedTimestamp2 = date('Y-m-d H:i:s', $timestampAfter3);
                if ($formattedCurrentTime > $formattedTimestamp2) {
                    $updateQuery = "UPDATE heals SET attacker_health = 0 WHERE attacker = '$attacker' AND defender = '$defender'";
                    $conn->query($updateQuery);
                }
        	}
            $updateQuery = "UPDATE heals SET attacker_number = '$randomNumber1', defender_number = '$randomNumber2', attacker_points = '$attackerpoint' WHERE attacker = '$attacker' AND defender = '$defender'";
            $conn->query($updateQuery);
                if($randomNumber1 > $randomNumber2){
                $getdefenderhealth  = $row['defender_health'];
                $getdefenderhealth += 1;
                $timestampFromDatabase = time();
                $timestampAfter2Hours = strtotime('+90 minutes', $timestampFromDatabase); 
                $formattedTimestamp = date('Y-m-d H:i:s', $timestampAfter2Hours);
                $updatehealth = "UPDATE heals SET defender_health = '$getdefenderhealth', defender_last_updated = '$formattedTimestamp' WHERE attacker = '$attacker' AND defender = '$defender'";
                $conn->query($updatehealth);
                    echo "  '$attacker' either hits or misses!";
                    // STEP 3 CALIING for defender
                    $maxTrials = 3;
                    $secondIsLarger = false;
                    for ($trial = 1; $trial <= $maxTrials; $trial++) {
                        if($trial == 1){
                            echo " '$defender' has been offered for RE-ROLL. ";
                        }
                        else{
                            echo " Again '$defender' has been offered for RE-ROLL. ";
                        }
                        $newrandomNumber = mt_rand(10, 20);
                        echo " Generating healer for player in '$trial' reroll";
                        if ($newrandomNumber > $randomNumber1) {
                            $secondIsLarger = true;
                            $updateattcknmb = "UPDATE heals SET defender_number = '$newrandomNumber'  WHERE attacker = '$attacker' AND defender = '$defender'";
                            $conn->query($updateattcknmb);
                            break; // Terminate the loop
                        }
                        else{
                            echo " Player again lost the by low heal in '$trial' reroll! ";
                        }
                    }
                    if ($secondIsLarger) {
                        echo " Finally! '$defender' won in the $trial Re-Roll against the healer. ";
                        $dmaxTrials = 3;
                        $dsecondIsLarger = false;
                        for ($dtrial = 1; $dtrial <= $dmaxTrials; $dtrial++) {
                            if($dtrial == 1){
                                echo " '$attacker' has been offered for RE-ROLL now. ";
                            }
                            else{
                                echo "Again '$attacker' has been offered for RE-ROLL. ";
                            }
                            $dnewrandomNumber = mt_rand(10, 20);
                            echo " Generating heal for healer in '$dtrial' reroll";
                            $attackerrerollnumb = $row['defender_number'];
                            // echo " Attacker number in which attacker won: '$attackerrerollnumb'";
                            if ($dnewrandomNumber > $attackerrerollnumb) {
                                $dsecondIsLarger = true;
                                $dupdateattcknmb = "UPDATE heals SET attacker_number = '$dnewrandomNumber'  WHERE attacker = '$attacker' AND defender = '$defender'";
                                $conn->query($dupdateattcknmb);
                                break; // Terminate the loop
                            }
                            else{
                                echo " Healer again lost the by low heal in '$trial' reroll! ";
                            }
                        }
                        if ($dsecondIsLarger) {
                            echo " Finally! '$attacker' won in the $dtrial Re-Roll against the player. ";
                            $asecondIsLarger = false;
                            for ($atrial = 1; $atrial <= $trial; $atrial++) {
                                if($atrial == 1){
                                    echo " '$defender' has been offered for RE-ROLL now. ";
                                }
                                else{
                                    echo "Again '$defender' has been offered for RE-ROLL. ";
                                }
                                $anewrandomNumber = mt_rand(10, 20);
                                echo " Generating healer for player in '$atrial' reroll";
                                $adefenderrerollnumb = $row['attacker_number'];
                                // echo " Defender number in which defender won: '$adefenderrerollnumb'";
                                if ($anewrandomNumber > $adefenderrerollnumb) {
                                    $asecondIsLarger = true;
                                    $aupdateattcknmb = "UPDATE heals SET defender_number = '$anewrandomNumber'  WHERE attacker = '$attacker' AND defender = '$defender'";
                                    $conn->query($aupdateattcknmb);
                                    break; // Terminate the loop
                                }
                                else{
                                    echo " Player again lost the by low heal in '$trial' reroll! ";
                                }
                            }
                            if ($asecondIsLarger) {
                                echo " Finally! '$defender' won in the $atrial Re-Roll against the healer. ";
                                $dfsecondIsLarger = false;
                                for ($dftrial = 1; $dftrial <= $dtrial; $dftrial++) {
                                    if($dftrial == 1){
                                        echo " '$attacker' has been offered for RE-ROLL now. ";
                                    }
                                    else{
                                        echo "Again '$attacker' has been offered for RE-ROLL. ";
                                    }
                                    $dfnewrandomNumber = mt_rand(10, 20);
                                    echo " Generating heal for healer in '$dftrial' reroll";
                                    $dfdefenderrerollnumb = $row['defender_number'];
                                    // echo " Defender number in which defender won: '$dfdefenderrerollnumb'";
                                    if ($dfnewrandomNumber > $dfdefenderrerollnumb) {
                                        $dfsecondIsLarger = true;
                                        $dfupdateattcknmb = "UPDATE heals SET attacker_number = '$dfnewrandomNumber'  WHERE attacker = '$attacker' AND defender = '$defender'";
                                        $conn->query($dfupdateattcknmb);
                                        break; // Terminate the loop
                                    }
                                    else{
                                        echo " Healer again lost the by low heal in '$dftrial' reroll! ";
                                    }
                                }
                                if ($asecondIsLarger) {
                                echo " Finally! '$attacker' won in the $dftrial Re-Roll against the healer. ";
                                }
                                else{
                                    echo " '$attacker' has no more RE-ROLLS left to heal back.";
                                }
                                
                            }
                            else{
                                echo " '$attacker' has no more RE-ROLLS left to heal back.";
                            }
                        }
                        else{
                            echo " In all Re-Rolls the '$attacker' couldn't against player. Now '$defender' is the final WINNER! ";
                        }
                    } else {
                        echo " In all Re-Rolls the '$defender' couldn't win the heal. Now '$attacker' is the final WINNER! ";
                    }
                
                }
                else{
                $getattackerhealth  = $row['attacker_health'];
                $getattackerhealth += 1;
                $timestampFromDatabase = time();
                $timestampAfter2Hours = strtotime('+90 minutes', $timestampFromDatabase); 
                $formattedTimestamp = date('Y-m-d H:i:s', $timestampAfter2Hours);
                $updatehealth = "UPDATE heals SET attacker_health = '$getattackerhealth', attacker_last_updated = '$formattedTimestamp' WHERE attacker = '$attacker' AND defender = '$defender'";
                $conn->query($updatehealth);
                echo "  Healer Lost the heal due to low Healer!";
                    echo "  '$defender' won by greater defence";
                // STEP 3 CALIING for attacker
                
                    $maxTrials = 3;
                    $secondIsLarger = false;
                    for ($trial = 1; $trial <= $maxTrials; $trial++) {
                        if($trial == 1){
                            echo " '$attacker' has been offered for RE-ROLL. ";
                        }
                        else{
                            echo "Again '$attacker' has been offered for RE-ROLL. ";
                        }
                        $newrandomNumber = mt_rand(10, 20);
                        echo " Generating heal for healer in '$trial' reroll"; 
                        if ($newrandomNumber > $randomNumber2) {
                            $secondIsLarger = true;
                            $updateattcknmb = "UPDATE heals SET attacker_number = '$newrandomNumber'  WHERE attacker = '$attacker' AND defender = '$defender'";
                            $conn->query($updateattcknmb);
                            break; // Terminate the loop
                        }
                        else{
                            echo " Healer again lost the by low heal in '$trial' reroll! ";
                        }
                    }
                    if ($secondIsLarger) {
                        echo " Finally! '$attacker' won in the $trial Re-Roll against the player. ";
                        $dmaxTrials = 3;
                        $dsecondIsLarger = false;
                        for ($dtrial = 1; $dtrial <= $dmaxTrials; $dtrial++) {
                            if($dtrial == 1){
                                echo " '$defender' has been offered for RE-ROLL now. ";
                            }
                            else{
                                echo "Again '$defender' has been offered for RE-ROLL. ";
                            }
                            $dnewrandomNumber = mt_rand(10, 20);
                            echo " Generating healer for player in '$dtrial' reroll";
                            $attackerrerollnumb = $row['attacker_number'];
                            // echo " Attacker number in which attacker won: '$attackerrerollnumb'";
                            if ($dnewrandomNumber > $attackerrerollnumb) {
                                $dsecondIsLarger = true;
                                $dupdateattcknmb = "UPDATE heals SET defender_number = '$dnewrandomNumber'  WHERE attacker = '$attacker' AND defender = '$defender'";
                                $conn->query($dupdateattcknmb);
                                break; // Terminate the loop
                            }
                            else{
                                echo " Player again lost the by low heal in '$trial' reroll! ";
                            }
                        }
                        if ($dsecondIsLarger) {
                            echo " Finally! '$defender' won in the $dtrial Re-Roll against the healer. ";
                            $asecondIsLarger = false;
                            for ($atrial = 1; $atrial <= $trial; $atrial++) {
                                if($atrial == 1){
                                    echo " '$attacker' has been offered for RE-ROLL now. ";
                                }
                                else{
                                    echo "Again '$attacker' has been offered for RE-ROLL. ";
                                }
                                $anewrandomNumber = mt_rand(10, 20);
                                echo " Generating heal for healer in '$atrial' reroll";
                                $adefenderrerollnumb = $row['defender_number'];
                                // echo " Defender number in which defender won: '$adefenderrerollnumb'";
                                if ($anewrandomNumber > $adefenderrerollnumb) {
                                    $asecondIsLarger = true;
                                    $aupdateattcknmb = "UPDATE heals SET attacker_number = '$anewrandomNumber'  WHERE attacker = '$attacker' AND defender = '$defender'";
                                    $conn->query($aupdateattcknmb);
                                    break; // Terminate the loop
                                }
                                else{
                                    echo " Healer again lost the by low heal in '$trial' reroll! ";
                                }
                            }
                            if ($asecondIsLarger) {
                                echo " Finally! '$attacker' won in the $atrial Re-Roll against the player. ";
                                $dfsecondIsLarger = false;
                                for ($dftrial = 1; $dftrial <= $dtrial; $dftrial++) {
                                    if($dftrial == 1){
                                        echo " '$defender' has been offered for RE-ROLL now. ";
                                    }
                                    else{
                                        echo "Again '$defender' has been offered for RE-ROLL. ";
                                    }
                                    $dfnewrandomNumber = mt_rand(10, 20);
                                    echo " Generating healer for player in '$dftrial' reroll";
                                    $dfdefenderrerollnumb = $row['attacker_number'];
                                    // echo " Defender number in which defender won: '$dfdefenderrerollnumb'";
                                    if ($dfnewrandomNumber > $dfdefenderrerollnumb) {
                                        $dfsecondIsLarger = true;
                                        $dfupdateattcknmb = "UPDATE heals SET defender_number = '$dfnewrandomNumber'  WHERE attacker = '$attacker' AND defender = '$defender'";
                                        $conn->query($dfupdateattcknmb);
                                        break; // Terminate the loop
                                    }
                                    else{
                                        echo " Player again lost the by low heal in '$dftrial' reroll! ";
                                    }
                                }
                                if ($asecondIsLarger) {
                                echo " Finally! '$defender' won in the $dftrial Re-Roll against the healer. ";
                                }
                                else{
                                    echo " '$defender' has no more RE-ROLLS left to heal back.";
                                }
                                
                            }
                            else{
                                echo " '$attacker' has no more RE-ROLLS left to heal back.";
                            }
                        }
                        else{
                            echo " In all Re-Rolls the '$defender' couldn't against player. Now '$attacker' is the final WINNER! ";
                        }
                    } else {
                        echo " In all Re-Rolls the '$attacker' couldn't win the heal. Now '$defender' is the final WINNER! ";
                    }
                
                }
            
        }
} else {
    // Row doesn't exist, insert a new row
    $insertQuery = "INSERT INTO heals (attacker, defender, attacker_health, defender_health) VALUES ('$attacker', '$defender', 0, 0)";
    
    if ($conn->query($insertQuery) === TRUE) {
        $newRowId = $conn->insert_id;

    // SQL query to select the newly inserted row by its ID
    $selectQuery = "SELECT * FROM heals WHERE id = $newRowId";
    $result = $conn->query($selectQuery);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $attackerpoint = $row['attacker_points'] + 1;
            $randomNumber = mt_rand(10, 20);
            $randomNumber1 = $randomNumber + $attackerpoint;
            $randomNumber2 = mt_rand(10, 20);
            echo "The Healer number is: ".$randomNumber1;
            echo " The Player number is: ".$randomNumber2;
            echo " Your health has been paused for 90 minutes.";
            $currenttime = time();
            $timestampAfter = strtotime('+1 second', $currenttime);
        	$formattedCurrentTime = date('Y-m-d H:i:s', $timestampAfter);
        	if($row['defender_last_updated'] !== null){
                $defendertime = $row['defender_last_updated'];
                $timestampAfter2 = strtotime($defendertime);
            	$formattedTimestamp = date('Y-m-d H:i:s', $timestampAfter2);
                if ($formattedCurrentTime > $formattedTimestamp) {
                    $updateQuery = "UPDATE heals SET defender_health = 0 WHERE attacker = '$attacker' AND defender = '$defender'";
                    $conn->query($updateQuery);
                }
        	}
        	if($row['attacker_last_updated'] !== null){
        	    $attackertime = $row['attacker_last_updated'];
                $timestampAfter3 = strtotime($attackertime);
            	$formattedTimestamp2 = date('Y-m-d H:i:s', $timestampAfter3);
                if ($formattedCurrentTime > $formattedTimestamp2) {
                    $updateQuery = "UPDATE heals SET attacker_health = 0 WHERE attacker = '$attacker' AND defender = '$defender'";
                    $conn->query($updateQuery);
                }
        	}
            $updateQuery = "UPDATE heals SET attacker_number = '$randomNumber1', defender_number = '$randomNumber2', attacker_points = '$attackerpoint' WHERE attacker = '$attacker' AND defender = '$defender'";
            $conn->query($updateQuery);
                if($randomNumber1 > $randomNumber2){
                $getdefenderhealth  = $row['defender_health'];
                $getdefenderhealth += 1;
                $timestampFromDatabase = time();
                $timestampAfter2Hours = strtotime('+90 minutes', $timestampFromDatabase); 
                $formattedTimestamp = date('Y-m-d H:i:s', $timestampAfter2Hours);
                $updatehealth = "UPDATE heals SET defender_health = '$getdefenderhealth', defender_last_updated = '$formattedTimestamp' WHERE attacker = '$attacker' AND defender = '$defender'";
                $conn->query($updatehealth);
                    echo "  '$attacker' either hits or misses!";
                    // STEP 3 CALIING for defender
                    $maxTrials = 3;
                    $secondIsLarger = false;
                    for ($trial = 1; $trial <= $maxTrials; $trial++) {
                        if($trial == 1){
                            echo " '$defender' has been offered for RE-ROLL. ";
                        }
                        else{
                            echo " Again '$defender' has been offered for RE-ROLL. ";
                        }
                        $newrandomNumber = mt_rand(10, 20);
                        echo " Generating healer for player in '$trial' reroll";
                        if ($newrandomNumber > $randomNumber1) {
                            $secondIsLarger = true;
                            $updateattcknmb = "UPDATE heals SET defender_number = '$newrandomNumber'  WHERE attacker = '$attacker' AND defender = '$defender'";
                            $conn->query($updateattcknmb);
                            break; // Terminate the loop
                        }
                        else{
                            echo " Player again lost the by low heal in '$trial' reroll! ";
                        }
                    }
                    if ($secondIsLarger) {
                        echo " Finally! '$defender' won in the $trial Re-Roll against the healer. ";
                        $dmaxTrials = 3;
                        $dsecondIsLarger = false;
                        for ($dtrial = 1; $dtrial <= $dmaxTrials; $dtrial++) {
                            if($dtrial == 1){
                                echo " '$attacker' has been offered for RE-ROLL now. ";
                            }
                            else{
                                echo "Again '$attacker' has been offered for RE-ROLL. ";
                            }
                            $dnewrandomNumber = mt_rand(10, 20);
                            echo " Generating heal for healer in '$dtrial' reroll";
                            $attackerrerollnumb = $row['defender_number'];
                            // echo " Attacker number in which attacker won: '$attackerrerollnumb'";
                            if ($dnewrandomNumber > $attackerrerollnumb) {
                                $dsecondIsLarger = true;
                                $dupdateattcknmb = "UPDATE heals SET attacker_number = '$dnewrandomNumber'  WHERE attacker = '$attacker' AND defender = '$defender'";
                                $conn->query($dupdateattcknmb);
                                break; // Terminate the loop
                            }
                            else{
                                echo " Healer again lost the by low heal in '$trial' reroll! ";
                            }
                        }
                        if ($dsecondIsLarger) {
                            echo " Finally! '$attacker' won in the $dtrial Re-Roll against the player. ";
                            $asecondIsLarger = false;
                            for ($atrial = 1; $atrial <= $trial; $atrial++) {
                                if($atrial == 1){
                                    echo " '$defender' has been offered for RE-ROLL now. ";
                                }
                                else{
                                    echo "Again '$defender' has been offered for RE-ROLL. ";
                                }
                                $anewrandomNumber = mt_rand(10, 20);
                                echo " Generating healer for player in '$atrial' reroll";
                                $adefenderrerollnumb = $row['attacker_number'];
                                // echo " Defender number in which defender won: '$adefenderrerollnumb'";
                                if ($anewrandomNumber > $adefenderrerollnumb) {
                                    $asecondIsLarger = true;
                                    $aupdateattcknmb = "UPDATE heals SET defender_number = '$anewrandomNumber'  WHERE attacker = '$attacker' AND defender = '$defender'";
                                    $conn->query($aupdateattcknmb);
                                    break; // Terminate the loop
                                }
                                else{
                                    echo " Player again lost the by low heal in '$trial' reroll! ";
                                }
                            }
                            if ($asecondIsLarger) {
                                echo " Finally! '$defender' won in the $atrial Re-Roll against the healer. ";
                                $dfsecondIsLarger = false;
                                for ($dftrial = 1; $dftrial <= $dtrial; $dftrial++) {
                                    if($dftrial == 1){
                                        echo " '$attacker' has been offered for RE-ROLL now. ";
                                    }
                                    else{
                                        echo "Again '$attacker' has been offered for RE-ROLL. ";
                                    }
                                    $dfnewrandomNumber = mt_rand(10, 20);
                                    echo " Generating heal for healer in '$dftrial' reroll";
                                    $dfdefenderrerollnumb = $row['defender_number'];
                                    // echo " Defender number in which defender won: '$dfdefenderrerollnumb'";
                                    if ($dfnewrandomNumber > $dfdefenderrerollnumb) {
                                        $dfsecondIsLarger = true;
                                        $dfupdateattcknmb = "UPDATE heals SET attacker_number = '$dfnewrandomNumber'  WHERE attacker = '$attacker' AND defender = '$defender'";
                                        $conn->query($dfupdateattcknmb);
                                        break; // Terminate the loop
                                    }
                                    else{
                                        echo " Healer again lost the by low heal in '$dftrial' reroll! ";
                                    }
                                }
                                if ($asecondIsLarger) {
                                echo " Finally! '$attacker' won in the $dftrial Re-Roll against the healer. ";
                                }
                                else{
                                    echo " '$attacker' has no more RE-ROLLS left to heal back.";
                                }
                                
                            }
                            else{
                                echo " '$attacker' has no more RE-ROLLS left to heal back.";
                            }
                        }
                        else{
                            echo " In all Re-Rolls the '$attacker' couldn't against player. Now '$defender' is the final WINNER! ";
                        }
                    } else {
                        echo " In all Re-Rolls the '$defender' couldn't win the heal. Now '$attacker' is the final WINNER! ";
                    }
                
                }
                else{
                $getattackerhealth  = $row['attacker_health'];
                $getattackerhealth += 1;
                $timestampFromDatabase = time();
                $timestampAfter2Hours = strtotime('+90 minutes', $timestampFromDatabase); 
                $formattedTimestamp = date('Y-m-d H:i:s', $timestampAfter2Hours);
                $updatehealth = "UPDATE heals SET attacker_health = '$getattackerhealth', attacker_last_updated = '$formattedTimestamp' WHERE attacker = '$attacker' AND defender = '$defender'";
                $conn->query($updatehealth);
                echo "  Healer Lost the heal due to low Healer!";
                    echo "  '$defender' won by greater defence";
                // STEP 3 CALIING for attacker
                
                    $maxTrials = 3;
                    $secondIsLarger = false;
                    for ($trial = 1; $trial <= $maxTrials; $trial++) {
                        if($trial == 1){
                            echo " '$attacker' has been offered for RE-ROLL. ";
                        }
                        else{
                            echo "Again '$attacker' has been offered for RE-ROLL. ";
                        }
                        $newrandomNumber = mt_rand(10, 20);
                        echo " Generating heal for healer in '$trial' reroll"; 
                        if ($newrandomNumber > $randomNumber2) {
                            $secondIsLarger = true;
                            $updateattcknmb = "UPDATE heals SET attacker_number = '$newrandomNumber'  WHERE attacker = '$attacker' AND defender = '$defender'";
                            $conn->query($updateattcknmb);
                            break; // Terminate the loop
                        }
                        else{
                            echo " Healer again lost the by low heal in '$trial' reroll! ";
                        }
                    }
                    if ($secondIsLarger) {
                        echo " Finally! '$attacker' won in the $trial Re-Roll against the player. ";
                        $dmaxTrials = 3;
                        $dsecondIsLarger = false;
                        for ($dtrial = 1; $dtrial <= $dmaxTrials; $dtrial++) {
                            if($dtrial == 1){
                                echo " '$defender' has been offered for RE-ROLL now. ";
                            }
                            else{
                                echo "Again '$defender' has been offered for RE-ROLL. ";
                            }
                            $dnewrandomNumber = mt_rand(10, 20);
                            echo " Generating healer for player in '$dtrial' reroll";
                            $attackerrerollnumb = $row['attacker_number'];
                            // echo " Attacker number in which attacker won: '$attackerrerollnumb'";
                            if ($dnewrandomNumber > $attackerrerollnumb) {
                                $dsecondIsLarger = true;
                                $dupdateattcknmb = "UPDATE heals SET defender_number = '$dnewrandomNumber'  WHERE attacker = '$attacker' AND defender = '$defender'";
                                $conn->query($dupdateattcknmb);
                                break; // Terminate the loop
                            }
                            else{
                                echo " Player again lost the by low heal in '$trial' reroll! ";
                            }
                        }
                        if ($dsecondIsLarger) {
                            echo " Finally! '$defender' won in the $dtrial Re-Roll against the healer. ";
                            $asecondIsLarger = false;
                            for ($atrial = 1; $atrial <= $trial; $atrial++) {
                                if($atrial == 1){
                                    echo " '$attacker' has been offered for RE-ROLL now. ";
                                }
                                else{
                                    echo "Again '$attacker' has been offered for RE-ROLL. ";
                                }
                                $anewrandomNumber = mt_rand(10, 20);
                                echo " Generating heal for healer in '$atrial' reroll";
                                $adefenderrerollnumb = $row['defender_number'];
                                // echo " Defender number in which defender won: '$adefenderrerollnumb'";
                                if ($anewrandomNumber > $adefenderrerollnumb) {
                                    $asecondIsLarger = true;
                                    $aupdateattcknmb = "UPDATE heals SET attacker_number = '$anewrandomNumber'  WHERE attacker = '$attacker' AND defender = '$defender'";
                                    $conn->query($aupdateattcknmb);
                                    break; // Terminate the loop
                                }
                                else{
                                    echo " Healer again lost the by low heal in '$trial' reroll! ";
                                }
                            }
                            if ($asecondIsLarger) {
                                echo " Finally! '$attacker' won in the $atrial Re-Roll against the player. ";
                                $dfsecondIsLarger = false;
                                for ($dftrial = 1; $dftrial <= $dtrial; $dftrial++) {
                                    if($dftrial == 1){
                                        echo " '$defender' has been offered for RE-ROLL now. ";
                                    }
                                    else{
                                        echo "Again '$defender' has been offered for RE-ROLL. ";
                                    }
                                    $dfnewrandomNumber = mt_rand(10, 20);
                                    echo " Generating healer for player in '$dftrial' reroll";
                                    $dfdefenderrerollnumb = $row['attacker_number'];
                                    // echo " Defender number in which defender won: '$dfdefenderrerollnumb'";
                                    if ($dfnewrandomNumber > $dfdefenderrerollnumb) {
                                        $dfsecondIsLarger = true;
                                        $dfupdateattcknmb = "UPDATE heals SET defender_number = '$dfnewrandomNumber'  WHERE attacker = '$attacker' AND defender = '$defender'";
                                        $conn->query($dfupdateattcknmb);
                                        break; // Terminate the loop
                                    }
                                    else{
                                        echo " Player again lost the by low heal in '$dftrial' reroll! ";
                                    }
                                }
                                if ($asecondIsLarger) {
                                echo " Finally! '$defender' won in the $dftrial Re-Roll against the healer. ";
                                }
                                else{
                                    echo " '$defender' has no more RE-ROLLS left to heal back.";
                                }
                                
                            }
                            else{
                                echo " '$attacker' has no more RE-ROLLS left to heal back.";
                            }
                        }
                        else{
                            echo " In all Re-Rolls the '$defender' couldn't against player. Now '$attacker' is the final WINNER! ";
                        }
                    } else {
                        echo " In all Re-Rolls the '$attacker' couldn't win the heal. Now '$defender' is the final WINNER! ";
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