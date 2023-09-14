<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
if (isset($_GET['attacker']) && isset($_GET['defender'])) {
    $attacker_lsl = $_GET['attacker'];
    $defender_lsl = $_GET['defender'];
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
        echo " Attacker and Defender already exist. ";
        while ($row = $result->fetch_assoc()) {
            if ($row['attacker_health'] > 0 && $row['defender_health'] > 0) {
                $attackerpoint = $row['attacker_points'] + 1;
                if($attackerpoint == 5){
                    echo "Your points have been exceeded to 5. Save your points for the next arrangement."; 
                }
                if($attackerpoint > 8){
                    echo "You have no more attack points left. 8 points have been exceeded.";
                    $attackerpoint = 8;
                }
                $randomNumber = mt_rand(1, 20);
                $randomNumber1 = $randomNumber + $attackerpoint;
                if($randomNumber1 > 20){
                    $randomNumber1 = 20;
                }
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
                    if($getattackerhealth > 0 ){
                        $maxTrials = 3;
                        $secondIsLarger = false;
                        for ($trial = 1; $trial <= $maxTrials; $trial++) {
                            if($trial == 1){
                                echo " '$attacker' has been offered for RE-ROLL. ";
                            }
                            else{
                                echo "Again '$attacker' has been offered for RE-ROLL. ";
                            }
                            $newrandomNumber = mt_rand(1, 20);
                            echo " Generating attack for Attacker in '$trial' reroll"; 
                            if ($newrandomNumber > $randomNumber2) {
                                $secondIsLarger = true;
                                $updateattcknmb = "UPDATE attacks SET attacker_number = '$newrandomNumber'  WHERE attacker = '$attacker' AND defender = '$defender'";
                                $conn->query($updateattcknmb);
                                break; // Terminate the loop
                            }
                            else{
                                echo " Attacker again lost the by low attack in '$trial' reroll! ";
                            }
                        }
                        if ($secondIsLarger) {
                            echo " Finally! '$attacker' won in the $trial Re-Roll against the defender. ";
                            $dmaxTrials = 3;
                            $dsecondIsLarger = false;
                            for ($dtrial = 1; $dtrial <= $dmaxTrials; $dtrial++) {
                                if($dtrial == 1){
                                    echo " '$defender' has been offered for RE-ROLL now. ";
                                }
                                else{
                                    echo "Again '$defender' has been offered for RE-ROLL. ";
                                }
                                $dnewrandomNumber = mt_rand(1, 20);
                                echo " Generating defence for defender in '$dtrial' reroll";
                                $attackerrerollnumb = $row['attacker_number'];
                                // echo " Attacker number in which attacker won: '$attackerrerollnumb'";
                                if ($dnewrandomNumber > $attackerrerollnumb) {
                                    $dsecondIsLarger = true;
                                    $dupdateattcknmb = "UPDATE attacks SET defender_number = '$dnewrandomNumber'  WHERE attacker = '$attacker' AND defender = '$defender'";
                                    $conn->query($dupdateattcknmb);
                                    break; // Terminate the loop
                                }
                                else{
                                    echo " Defender again lost the by low defence in '$trial' reroll! ";
                                }
                            }
                            if ($dsecondIsLarger) {
                                echo " Finally! '$defender' won in the $dtrial Re-Roll against the attacker. ";
                                $asecondIsLarger = false;
                                for ($atrial = 1; $atrial <= $trial; $atrial++) {
                                    if($atrial == 1){
                                        echo " '$attacker' has been offered for RE-ROLL now. ";
                                    }
                                    else{
                                        echo "Again '$attacker' has been offered for RE-ROLL. ";
                                    }
                                    $anewrandomNumber = mt_rand(1, 20);
                                    echo " Generating attack for Attacker in '$atrial' reroll";
                                    $adefenderrerollnumb = $row['defender_number'];
                                    // echo " Defender number in which defender won: '$adefenderrerollnumb'";
                                    if ($anewrandomNumber > $adefenderrerollnumb) {
                                        $asecondIsLarger = true;
                                        $aupdateattcknmb = "UPDATE attacks SET attacker_number = '$anewrandomNumber'  WHERE attacker = '$attacker' AND defender = '$defender'";
                                        $conn->query($aupdateattcknmb);
                                        break; // Terminate the loop
                                    }
                                    else{
                                        echo " Attacker again lost the by low attack in '$trial' reroll! ";
                                    }
                                }
                                if ($asecondIsLarger) {
                                    echo " Finally! '$attacker' won in the $atrial Re-Roll against the defender. ";
                                    $dfsecondIsLarger = false;
                                    for ($dftrial = 1; $dftrial <= $dtrial; $dftrial++) {
                                        if($dftrial == 1){
                                            echo " '$defender' has been offered for RE-ROLL now. ";
                                        }
                                        else{
                                            echo "Again '$defender' has been offered for RE-ROLL. ";
                                        }
                                        $dfnewrandomNumber = mt_rand(1, 20);
                                        echo " Generating defence for defender in '$dftrial' reroll";
                                        $dfdefenderrerollnumb = $row['attacker_number'];
                                        // echo " Defender number in which defender won: '$dfdefenderrerollnumb'";
                                        if ($dfnewrandomNumber > $dfdefenderrerollnumb) {
                                            $dfsecondIsLarger = true;
                                            $dfupdateattcknmb = "UPDATE attacks SET defender_number = '$dfnewrandomNumber'  WHERE attacker = '$attacker' AND defender = '$defender'";
                                            $conn->query($dfupdateattcknmb);
                                            break; // Terminate the loop
                                        }
                                        else{
                                            echo " Defender again lost the by low defence in '$dftrial' reroll! ";
                                        }
                                    }
                                    if ($asecondIsLarger) {
                                    echo " Finally! '$defender' won in the $dftrial Re-Roll against the attacker. ";
                                    }
                                    else{
                                        echo " '$defender' has no more RE-ROLLS left to attack back.";
                                    }
                                    
                                }
                                else{
                                    echo " '$attacker' has no more RE-ROLLS left to attack back.";
                                }
                            }
                            else{
                                echo " In all Re-Rolls the '$defender' couldn't against defender. Now '$attacker' is the final WINNER! ";
                            }
                        } else {
                            echo " In all Re-Rolls the '$attacker' couldn't win the attack. Now '$defender' is the final WINNER! ";
                        }
                    }
                    else{
                        echo " Attacker or Defender Health is below 0 for RE-Roll! ";
                    }
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
                    if($getdefenderhealth > 0 ){
                        $maxTrials = 3;
                        $secondIsLarger = false;
                        for ($trial = 1; $trial <= $maxTrials; $trial++) {
                            if($trial == 1){
                                echo " '$defender' has been offered for RE-ROLL. ";
                            }
                            else{
                                echo " Again '$defender' has been offered for RE-ROLL. ";
                            }
                            $newrandomNumber = mt_rand(1, 20);
                            echo " Generating defence for defender in '$trial' reroll";
                            if ($newrandomNumber > $randomNumber1) {
                                $secondIsLarger = true;
                                $updateattcknmb = "UPDATE attacks SET defender_number = '$newrandomNumber'  WHERE attacker = '$attacker' AND defender = '$defender'";
                                $conn->query($updateattcknmb);
                                break; // Terminate the loop
                            }
                            else{
                                echo " Defender again lost the by low defence in '$trial' reroll! ";
                            }
                        }
                        if ($secondIsLarger) {
                            echo " Finally! '$defender' won in the $trial Re-Roll against the attacker. ";
                            $dmaxTrials = 3;
                            $dsecondIsLarger = false;
                            for ($dtrial = 1; $dtrial <= $dmaxTrials; $dtrial++) {
                                if($dtrial == 1){
                                    echo " '$attacker' has been offered for RE-ROLL now. ";
                                }
                                else{
                                    echo "Again '$attacker' has been offered for RE-ROLL. ";
                                }
                                $dnewrandomNumber = mt_rand(1, 20);
                                echo " Generating attack for Attacker in '$dtrial' reroll";
                                $attackerrerollnumb = $row['defender_number'];
                                // echo " Attacker number in which attacker won: '$attackerrerollnumb'";
                                if ($dnewrandomNumber > $attackerrerollnumb) {
                                    $dsecondIsLarger = true;
                                    $dupdateattcknmb = "UPDATE attacks SET attacker_number = '$dnewrandomNumber'  WHERE attacker = '$attacker' AND defender = '$defender'";
                                    $conn->query($dupdateattcknmb);
                                    break; // Terminate the loop
                                }
                                else{
                                    echo " Attacker again lost the by low attack in '$trial' reroll! ";
                                }
                            }
                            if ($dsecondIsLarger) {
                                echo " Finally! '$attacker' won in the $dtrial Re-Roll against the defender. ";
                                $asecondIsLarger = false;
                                for ($atrial = 1; $atrial <= $trial; $atrial++) {
                                    if($atrial == 1){
                                        echo " '$defender' has been offered for RE-ROLL now. ";
                                    }
                                    else{
                                        echo "Again '$defender' has been offered for RE-ROLL. ";
                                    }
                                    $anewrandomNumber = mt_rand(1, 20);
                                    echo " Generating defence for defender in '$atrial' reroll";
                                    $adefenderrerollnumb = $row['attacker_number'];
                                    // echo " Defender number in which defender won: '$adefenderrerollnumb'";
                                    if ($anewrandomNumber > $adefenderrerollnumb) {
                                        $asecondIsLarger = true;
                                        $aupdateattcknmb = "UPDATE attacks SET defender_number = '$anewrandomNumber'  WHERE attacker = '$attacker' AND defender = '$defender'";
                                        $conn->query($aupdateattcknmb);
                                        break; // Terminate the loop
                                    }
                                    else{
                                        echo " Defender again lost the by low attack in '$trial' reroll! ";
                                    }
                                }
                                if ($asecondIsLarger) {
                                    echo " Finally! '$defender' won in the $atrial Re-Roll against the attacker. ";
                                    $dfsecondIsLarger = false;
                                    for ($dftrial = 1; $dftrial <= $dtrial; $dftrial++) {
                                        if($dftrial == 1){
                                            echo " '$attacker' has been offered for RE-ROLL now. ";
                                        }
                                        else{
                                            echo "Again '$attacker' has been offered for RE-ROLL. ";
                                        }
                                        $dfnewrandomNumber = mt_rand(1, 20);
                                        echo " Generating attack for Attacker in '$dftrial' reroll";
                                        $dfdefenderrerollnumb = $row['defender_number'];
                                        // echo " Defender number in which defender won: '$dfdefenderrerollnumb'";
                                        if ($dfnewrandomNumber > $dfdefenderrerollnumb) {
                                            $dfsecondIsLarger = true;
                                            $dfupdateattcknmb = "UPDATE attacks SET attacker_number = '$dfnewrandomNumber'  WHERE attacker = '$attacker' AND defender = '$defender'";
                                            $conn->query($dfupdateattcknmb);
                                            break; // Terminate the loop
                                        }
                                        else{
                                            echo " Attacker again lost the by low attack in '$dftrial' reroll! ";
                                        }
                                    }
                                    if ($asecondIsLarger) {
                                    echo " Finally! '$attacker' won in the $dftrial Re-Roll against the attacker. ";
                                    }
                                    else{
                                        echo " '$attacker' has no more RE-ROLLS left to attack back.";
                                    }
                                    
                                }
                                else{
                                    echo " '$attacker' has no more RE-ROLLS left to attack back.";
                                }
                            }
                            else{
                                echo " In all Re-Rolls the '$attacker' couldn't against defender. Now '$defender' is the final WINNER! ";
                            }
                        } else {
                            echo " In all Re-Rolls the '$defender' couldn't win the attack. Now '$attacker' is the final WINNER! ";
                        }
                    }
                    else{
                        echo " Attacker or Defender Health is below 0 for RE-Roll! ";
                    }
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
                    if($getdefenderhealth > 0 ){
                        $maxTrials = 3;
                        $secondIsLarger = false;
                        for ($trial = 1; $trial <= $maxTrials; $trial++) {
                            if($trial == 1){
                                echo " '$defender' has been offered for RE-ROLL. ";
                            }
                            else{
                                echo " Again '$defender' has been offered for RE-ROLL. ";
                            }
                            $newrandomNumber = mt_rand(1, 20);
                            echo " Generating defence for defender in '$trial' reroll";
                            if ($newrandomNumber > $randomNumber1) {
                                $secondIsLarger = true;
                                $updateattcknmb = "UPDATE attacks SET defender_number = '$newrandomNumber'  WHERE attacker = '$attacker' AND defender = '$defender'";
                                $conn->query($updateattcknmb);
                                break; // Terminate the loop
                            }
                            else{
                                echo " Defender again lost the by low defence in '$trial' reroll! ";
                            }
                        }
                        if ($secondIsLarger) {
                            echo " Finally! '$defender' won in the $trial Re-Roll against the attacker. ";
                            $dmaxTrials = 3;
                            $dsecondIsLarger = false;
                            for ($dtrial = 1; $dtrial <= $dmaxTrials; $dtrial++) {
                                if($dtrial == 1){
                                    echo " '$attacker' has been offered for RE-ROLL now. ";
                                }
                                else{
                                    echo "Again '$attacker' has been offered for RE-ROLL. ";
                                }
                                $dnewrandomNumber = mt_rand(1, 20);
                                echo " Generating attack for Attacker in '$dtrial' reroll";
                                $attackerrerollnumb = $row['defender_number'];
                                // echo " Attacker number in which attacker won: '$attackerrerollnumb'";
                                if ($dnewrandomNumber > $attackerrerollnumb) {
                                    $dsecondIsLarger = true;
                                    $dupdateattcknmb = "UPDATE attacks SET attacker_number = '$dnewrandomNumber'  WHERE attacker = '$attacker' AND defender = '$defender'";
                                    $conn->query($dupdateattcknmb);
                                    break; // Terminate the loop
                                }
                                else{
                                    echo " Attacker again lost the by low attack in '$trial' reroll! ";
                                }
                            }
                            if ($dsecondIsLarger) {
                                echo " Finally! '$attacker' won in the $dtrial Re-Roll against the defender. ";
                                $asecondIsLarger = false;
                                for ($atrial = 1; $atrial <= $trial; $atrial++) {
                                    if($atrial == 1){
                                        echo " '$defender' has been offered for RE-ROLL now. ";
                                    }
                                    else{
                                        echo "Again '$defender' has been offered for RE-ROLL. ";
                                    }
                                    $anewrandomNumber = mt_rand(1, 20);
                                    echo " Generating defence for defender in '$atrial' reroll";
                                    $adefenderrerollnumb = $row['attacker_number'];
                                    // echo " Defender number in which defender won: '$adefenderrerollnumb'";
                                    if ($anewrandomNumber > $adefenderrerollnumb) {
                                        $asecondIsLarger = true;
                                        $aupdateattcknmb = "UPDATE attacks SET defender_number = '$anewrandomNumber'  WHERE attacker = '$attacker' AND defender = '$defender'";
                                        $conn->query($aupdateattcknmb);
                                        break; // Terminate the loop
                                    }
                                    else{
                                        echo " Defender again lost the by low attack in '$trial' reroll! ";
                                    }
                                }
                                if ($asecondIsLarger) {
                                    echo " Finally! '$defender' won in the $atrial Re-Roll against the attacker. ";
                                    $dfsecondIsLarger = false;
                                    for ($dftrial = 1; $dftrial <= $dtrial; $dftrial++) {
                                        if($dftrial == 1){
                                            echo " '$attacker' has been offered for RE-ROLL now. ";
                                        }
                                        else{
                                            echo "Again '$attacker' has been offered for RE-ROLL. ";
                                        }
                                        $dfnewrandomNumber = mt_rand(1, 20);
                                        echo " Generating attack for Attacker in '$dftrial' reroll";
                                        $dfdefenderrerollnumb = $row['defender_number'];
                                        // echo " Defender number in which defender won: '$dfdefenderrerollnumb'";
                                        if ($dfnewrandomNumber > $dfdefenderrerollnumb) {
                                            $dfsecondIsLarger = true;
                                            $dfupdateattcknmb = "UPDATE attacks SET attacker_number = '$dfnewrandomNumber'  WHERE attacker = '$attacker' AND defender = '$defender'";
                                            $conn->query($dfupdateattcknmb);
                                            break; // Terminate the loop
                                        }
                                        else{
                                            echo " Attacker again lost the by low attack in '$dftrial' reroll! ";
                                        }
                                    }
                                    if ($asecondIsLarger) {
                                    echo " Finally! '$attacker' won in the $dftrial Re-Roll against the attacker. ";
                                    }
                                    else{
                                        echo " '$attacker' has no more RE-ROLLS left to attack back.";
                                    }
                                    
                                }
                                else{
                                    echo " '$attacker' has no more RE-ROLLS left to attack back.";
                                }
                            }
                            else{
                                echo " In all Re-Rolls the '$attacker' couldn't against defender. Now '$defender' is the final WINNER! ";
                            }
                        } else {
                            echo " In all Re-Rolls the '$defender' couldn't win the attack. Now '$attacker' is the final WINNER! ";
                        }
                    }
                    else{
                        echo " Attacker or Defender Health is below 0 for RE-Roll! ";
                    }
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
                    if($getattackerhealth > 0 ){
                        $maxTrials = 3;
                        $secondIsLarger = false;
                        for ($trial = 1; $trial <= $maxTrials; $trial++) {
                            if($trial == 1){
                                echo " '$attacker' has been offered for RE-ROLL. ";
                            }
                            else{
                                echo "Again '$attacker' has been offered for RE-ROLL. ";
                            }
                            $newrandomNumber = mt_rand(1, 20);
                            echo " Generating attack for Attacker in '$trial' reroll"; 
                            if ($newrandomNumber > $randomNumber2) {
                                $secondIsLarger = true;
                                $updateattcknmb = "UPDATE attacks SET attacker_number = '$newrandomNumber'  WHERE attacker = '$attacker' AND defender = '$defender'";
                                $conn->query($updateattcknmb);
                                break; // Terminate the loop
                            }
                            else{
                                echo " Attacker again lost the by low attack in '$trial' reroll! ";
                            }
                        }
                        if ($secondIsLarger) {
                            echo " Finally! '$attacker' won in the $trial Re-Roll against the defender. ";
                            $dmaxTrials = 3;
                            $dsecondIsLarger = false;
                            for ($dtrial = 1; $dtrial <= $dmaxTrials; $dtrial++) {
                                if($dtrial == 1){
                                    echo " '$defender' has been offered for RE-ROLL now. ";
                                }
                                else{
                                    echo "Again '$defender' has been offered for RE-ROLL. ";
                                }
                                $dnewrandomNumber = mt_rand(1, 20);
                                echo " Generating defence for defender in '$dtrial' reroll";
                                $attackerrerollnumb = $row['attacker_number'];
                                // echo " Attacker number in which attacker won: '$attackerrerollnumb'";
                                if ($dnewrandomNumber > $attackerrerollnumb) {
                                    $dsecondIsLarger = true;
                                    $dupdateattcknmb = "UPDATE attacks SET defender_number = '$dnewrandomNumber'  WHERE attacker = '$attacker' AND defender = '$defender'";
                                    $conn->query($dupdateattcknmb);
                                    break; // Terminate the loop
                                }
                                else{
                                    echo " Defender again lost the by low defence in '$trial' reroll! ";
                                }
                            }
                            if ($dsecondIsLarger) {
                                echo " Finally! '$defender' won in the $dtrial Re-Roll against the attacker. ";
                                $asecondIsLarger = false;
                                for ($atrial = 1; $atrial <= $trial; $atrial++) {
                                    if($atrial == 1){
                                        echo " '$attacker' has been offered for RE-ROLL now. ";
                                    }
                                    else{
                                        echo "Again '$attacker' has been offered for RE-ROLL. ";
                                    }
                                    $anewrandomNumber = mt_rand(1, 20);
                                    echo " Generating attack for Attacker in '$atrial' reroll";
                                    $adefenderrerollnumb = $row['defender_number'];
                                    // echo " Defender number in which defender won: '$adefenderrerollnumb'";
                                    if ($anewrandomNumber > $adefenderrerollnumb) {
                                        $asecondIsLarger = true;
                                        $aupdateattcknmb = "UPDATE attacks SET attacker_number = '$anewrandomNumber'  WHERE attacker = '$attacker' AND defender = '$defender'";
                                        $conn->query($aupdateattcknmb);
                                        break; // Terminate the loop
                                    }
                                    else{
                                        echo " Attacker again lost the by low attack in '$trial' reroll! ";
                                    }
                                }
                                if ($asecondIsLarger) {
                                    echo " Finally! '$attacker' won in the $atrial Re-Roll against the defender. ";
                                    $dfsecondIsLarger = false;
                                    for ($dftrial = 1; $dftrial <= $dtrial; $dftrial++) {
                                        if($dftrial == 1){
                                            echo " '$defender' has been offered for RE-ROLL now. ";
                                        }
                                        else{
                                            echo "Again '$defender' has been offered for RE-ROLL. ";
                                        }
                                        $dfnewrandomNumber = mt_rand(1, 20);
                                        echo " Generating defence for defender in '$dftrial' reroll";
                                        $dfdefenderrerollnumb = $row['attacker_number'];
                                        // echo " Defender number in which defender won: '$dfdefenderrerollnumb'";
                                        if ($dfnewrandomNumber > $dfdefenderrerollnumb) {
                                            $dfsecondIsLarger = true;
                                            $dfupdateattcknmb = "UPDATE attacks SET defender_number = '$dfnewrandomNumber'  WHERE attacker = '$attacker' AND defender = '$defender'";
                                            $conn->query($dfupdateattcknmb);
                                            break; // Terminate the loop
                                        }
                                        else{
                                            echo " Defender again lost the by low defence in '$dftrial' reroll! ";
                                        }
                                    }
                                    if ($asecondIsLarger) {
                                    echo " Finally! '$defender' won in the $dftrial Re-Roll against the attacker. ";
                                    }
                                    else{
                                        echo " '$defender' has no more RE-ROLLS left to attack back.";
                                    }
                                    
                                }
                                else{
                                    echo " '$attacker' has no more RE-ROLLS left to attack back.";
                                }
                            }
                            else{
                                echo " In all Re-Rolls the '$defender' couldn't against defender. Now '$attacker' is the final WINNER! ";
                            }
                        } else {
                            echo " In all Re-Rolls the '$attacker' couldn't win the attack. Now '$defender' is the final WINNER! ";
                        }
                    }
                    else{
                        echo " Attacker or Defender Health is below 0 for RE-Roll! ";
                    }
                    }
                    
                }
                
            } else {
                echo " Player has no health!";
            }
        }
    } else {
        // echo " Profile created successfully. ";
        $attacker_token = str_replace('.', '', uniqid('', true));
        $defender_token = str_replace('.', '', uniqid('', true));
        $player_token = str_replace('.', '', uniqid('', true));
        // Row doesn't exist, insert a new row
        // $insertQuery = "INSERT INTO attacks (attacker, defender, attacker_health, defender_health, attacker_token, defender_token) VALUES ('$attacker', '$defender', 6, 6, $attacker_token, $defender_token)";
         $stmt = $conn->prepare("INSERT INTO attacks (attacker,defender, attacker_health,defender_health,  attacker_token, defender_token, player_token) VALUES ('$attacker', '$defender', 6, 6, ?, ?, ?)");
    
            // Bind the values to the prepared statement as strings
            $stmt->bind_param("sss", $attacker_token, $defender_token, $player_token);
        if ($stmt->execute()) {
            $newRowId = $conn->insert_id;
    
        // SQL query to select the newly inserted row by its ID
        $selectQuery = "SELECT * FROM attacks WHERE id = $newRowId";
        $result = $conn->query($selectQuery);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $token = $row['player_token'];
                echo " Players profile created successfully! ";
                echo " Click this link below then select the POINTS to start battle and Re-Roll: ";
                echo " https://cityofrumor.com/server/points.php?id=$token";
                echo " Pause for Sleep now. ";
                sleep(20);
                echo " Sleep Resumed. ";
            }
        //     while ($row = $result->fetch_assoc()) {
        //         $attackerpoint = $row['attacker_points'] + 1;
        //         if($attackerpoint == 5){
        //             echo "Your points have been exceeded to 5. Save your points for the next arrangement."; 
        //         }
        //         if($attackerpoint > 8){
        //             echo "You have no more attack points left. 8 points have been exceeded.";
        //             $attackerpoint = 8;
        //         }
        //         $randomNumber = mt_rand(1, 20);
        //         $randomNumber1 = $randomNumber + $attackerpoint;
        //         if($randomNumber1 > 20){
        //             $randomNumber1 = 20;
        //         }
        //         $randomNumber2 = mt_rand(1, 20);
        //         echo "The attacker number is: ".$randomNumber1;
        //         echo " The defender number is: ".$randomNumber2;
        //         echo " Your health has been paused for 2 hours.";
        //         $currenttime = time();
        //         $timestampAfter = strtotime('+1 second', $currenttime);
        //     	$formattedCurrentTime = date('Y-m-d H:i:s', $timestampAfter);
        //     	if($row['defender_last_updated'] !== null){
        //             $defendertime = $row['defender_last_updated'];
        //             $timestampAfter2 = strtotime($defendertime);
        //         	$formattedTimestamp = date('Y-m-d H:i:s', $timestampAfter2);
        //             if ($formattedCurrentTime > $formattedTimestamp) {
        //                 $updateQuery = "UPDATE attacks SET defender_health = 6 WHERE attacker = '$attacker' AND defender = '$defender'";
        //                 $conn->query($updateQuery);
        //             }
        //     	}
        //     	if($row['attacker_last_updated'] !== null){
        //     	    $attackertime = $row['attacker_last_updated'];
        //             $timestampAfter3 = strtotime($attackertime);
        //         	$formattedTimestamp2 = date('Y-m-d H:i:s', $timestampAfter3);
        //             if ($formattedCurrentTime > $formattedTimestamp2) {
        //                 $updateQuery = "UPDATE attacks SET attacker_health = 6 WHERE attacker = '$attacker' AND defender = '$defender'";
        //                 $conn->query($updateQuery);
        //             }
        //     	}
        //         $updateQuery = "UPDATE attacks SET attacker_number = '$randomNumber1', defender_number = '$randomNumber2', attacker_points = '$attackerpoint' WHERE attacker = '$attacker' AND defender = '$defender'";
        //         $conn->query($updateQuery);
        //         if($randomNumber1 < 5){
        //             $getattackerhealth  = $row['attacker_health'];
        //             $getattackerhealth -= 1;
        //             $timestampFromDatabase = time();
        //             $timestampAfter2Hours = strtotime('+2 hours', $timestampFromDatabase); 
        //             $formattedTimestamp = date('Y-m-d H:i:s', $timestampAfter2Hours);
        //             $updatehealth = "UPDATE attacks SET attacker_health = '$getattackerhealth', attacker_last_updated = '$formattedTimestamp' WHERE attacker = '$attacker' AND defender = '$defender'";
        //             $conn->query($updatehealth);
        //             echo " Attacker Lost the Attack due to low Attack!";
        //             // STEP 3 CALIING for attacker
        //             if($getattackerhealth > 0 ){
        //                 $maxTrials = 3;
        //                 $secondIsLarger = false;
        //                 for ($trial = 1; $trial <= $maxTrials; $trial++) {
        //                     if($trial == 1){
        //                         echo " '$attacker' has been offered for RE-ROLL. ";
        //                     }
        //                     else{
        //                         echo "Again '$attacker' has been offered for RE-ROLL. ";
        //                     }
        //                     $newrandomNumber = mt_rand(1, 20);
        //                     echo " Generating attack for Attacker in '$trial' reroll"; 
        //                     if ($newrandomNumber > $randomNumber2) {
        //                         $secondIsLarger = true;
        //                         $updateattcknmb = "UPDATE attacks SET attacker_number = '$newrandomNumber'  WHERE attacker = '$attacker' AND defender = '$defender'";
        //                         $conn->query($updateattcknmb);
        //                         break; // Terminate the loop
        //                     }
        //                     else{
        //                         echo " Attacker again lost the by low attack in '$trial' reroll! ";
        //                     }
        //                 }
        //                 if ($secondIsLarger) {
        //                     echo " Finally! '$attacker' won in the $trial Re-Roll against the defender. ";
        //                     $dmaxTrials = 3;
        //                     $dsecondIsLarger = false;
        //                     for ($dtrial = 1; $dtrial <= $dmaxTrials; $dtrial++) {
        //                         if($dtrial == 1){
        //                             echo " '$defender' has been offered for RE-ROLL now. ";
        //                         }
        //                         else{
        //                             echo "Again '$defender' has been offered for RE-ROLL. ";
        //                         }
        //                         $dnewrandomNumber = mt_rand(1, 20);
        //                         echo " Generating defence for defender in '$dtrial' reroll";
        //                         $attackerrerollnumb = $row['attacker_number'];
        //                         // echo " Attacker number in which attacker won: '$attackerrerollnumb'";
        //                         if ($dnewrandomNumber > $attackerrerollnumb) {
        //                             $dsecondIsLarger = true;
        //                             $dupdateattcknmb = "UPDATE attacks SET defender_number = '$dnewrandomNumber'  WHERE attacker = '$attacker' AND defender = '$defender'";
        //                             $conn->query($dupdateattcknmb);
        //                             break; // Terminate the loop
        //                         }
        //                         else{
        //                             echo " Defender again lost the by low defence in '$trial' reroll! ";
        //                         }
        //                     }
        //                     if ($dsecondIsLarger) {
        //                         echo " Finally! '$defender' won in the $dtrial Re-Roll against the attacker. ";
        //                         $asecondIsLarger = false;
        //                         for ($atrial = 1; $atrial <= $trial; $atrial++) {
        //                             if($atrial == 1){
        //                                 echo " '$attacker' has been offered for RE-ROLL now. ";
        //                             }
        //                             else{
        //                                 echo "Again '$attacker' has been offered for RE-ROLL. ";
        //                             }
        //                             $anewrandomNumber = mt_rand(1, 20);
        //                             echo " Generating attack for Attacker in '$atrial' reroll";
        //                             $adefenderrerollnumb = $row['defender_number'];
        //                             // echo " Defender number in which defender won: '$adefenderrerollnumb'";
        //                             if ($anewrandomNumber > $adefenderrerollnumb) {
        //                                 $asecondIsLarger = true;
        //                                 $aupdateattcknmb = "UPDATE attacks SET attacker_number = '$anewrandomNumber'  WHERE attacker = '$attacker' AND defender = '$defender'";
        //                                 $conn->query($aupdateattcknmb);
        //                                 break; // Terminate the loop
        //                             }
        //                             else{
        //                                 echo " Attacker again lost the by low attack in '$trial' reroll! ";
        //                             }
        //                         }
        //                         if ($asecondIsLarger) {
        //                             echo " Finally! '$attacker' won in the $atrial Re-Roll against the defender. ";
        //                             $dfsecondIsLarger = false;
        //                             for ($dftrial = 1; $dftrial <= $dtrial; $dftrial++) {
        //                                 if($dftrial == 1){
        //                                     echo " '$defender' has been offered for RE-ROLL now. ";
        //                                 }
        //                                 else{
        //                                     echo "Again '$defender' has been offered for RE-ROLL. ";
        //                                 }
        //                                 $dfnewrandomNumber = mt_rand(1, 20);
        //                                 echo " Generating defence for defender in '$dftrial' reroll";
        //                                 $dfdefenderrerollnumb = $row['attacker_number'];
        //                                 // echo " Defender number in which defender won: '$dfdefenderrerollnumb'";
        //                                 if ($dfnewrandomNumber > $dfdefenderrerollnumb) {
        //                                     $dfsecondIsLarger = true;
        //                                     $dfupdateattcknmb = "UPDATE attacks SET defender_number = '$dfnewrandomNumber'  WHERE attacker = '$attacker' AND defender = '$defender'";
        //                                     $conn->query($dfupdateattcknmb);
        //                                     break; // Terminate the loop
        //                                 }
        //                                 else{
        //                                     echo " Defender again lost the by low defence in '$dftrial' reroll! ";
        //                                 }
        //                             }
        //                             if ($asecondIsLarger) {
        //                             echo " Finally! '$defender' won in the $dftrial Re-Roll against the attacker. ";
        //                             }
        //                             else{
        //                                 echo " '$defender' has no more RE-ROLLS left to attack back.";
        //                             }
                                    
        //                         }
        //                         else{
        //                             echo " '$attacker' has no more RE-ROLLS left to attack back.";
        //                         }
        //                     }
        //                     else{
        //                         echo " In all Re-Rolls the '$defender' couldn't against defender. Now '$attacker' is the final WINNER! ";
        //                     }
        //                 } else {
        //                     echo " In all Re-Rolls the '$attacker' couldn't win the attack. Now '$defender' is the final WINNER! ";
        //                 }
        //             }
        //             else{
        //                 echo " Attacker or Defender Health is below 0 for RE-Roll! ";
        //             }
        //         }
        //         elseif($randomNumber2 < 5){
        //             $getdefenderhealth  = $row['defender_health'];
        //             $getdefenderhealth -= 1;
        //             $timestampFromDatabase = time();
        //             $timestampAfter2Hours = strtotime('+2 hours', $timestampFromDatabase); 
        //             $formattedTimestamp = date('Y-m-d H:i:s', $timestampAfter2Hours);
        //             $updatehealth = "UPDATE attacks SET defender_health = '$getdefenderhealth', defender_last_updated = '$formattedTimestamp' WHERE attacker = '$attacker' AND defender = '$defender'";
        //             $conn->query($updatehealth);
        //             echo " Defender Lost due to low defence!";
        //             // STEP 3 CALIING for defender
        //             if($getdefenderhealth > 0 ){
        //                 $maxTrials = 3;
        //                 $secondIsLarger = false;
        //                 for ($trial = 1; $trial <= $maxTrials; $trial++) {
        //                     if($trial == 1){
        //                         echo " '$defender' has been offered for RE-ROLL. ";
        //                     }
        //                     else{
        //                         echo " Again '$defender' has been offered for RE-ROLL. ";
        //                     }
        //                     $newrandomNumber = mt_rand(1, 20);
        //                     echo " Generating defence for defender in '$trial' reroll";
        //                     if ($newrandomNumber > $randomNumber1) {
        //                         $secondIsLarger = true;
        //                         $updateattcknmb = "UPDATE attacks SET defender_number = '$newrandomNumber'  WHERE attacker = '$attacker' AND defender = '$defender'";
        //                         $conn->query($updateattcknmb);
        //                         break; // Terminate the loop
        //                     }
        //                     else{
        //                         echo " Defender again lost the by low defence in '$trial' reroll! ";
        //                     }
        //                 }
        //                 if ($secondIsLarger) {
        //                     echo " Finally! '$defender' won in the $trial Re-Roll against the attacker. ";
        //                     $dmaxTrials = 3;
        //                     $dsecondIsLarger = false;
        //                     for ($dtrial = 1; $dtrial <= $dmaxTrials; $dtrial++) {
        //                         if($dtrial == 1){
        //                             echo " '$attacker' has been offered for RE-ROLL now. ";
        //                         }
        //                         else{
        //                             echo "Again '$attacker' has been offered for RE-ROLL. ";
        //                         }
        //                         $dnewrandomNumber = mt_rand(1, 20);
        //                         echo " Generating attack for Attacker in '$dtrial' reroll";
        //                         $attackerrerollnumb = $row['defender_number'];
        //                         // echo " Attacker number in which attacker won: '$attackerrerollnumb'";
        //                         if ($dnewrandomNumber > $attackerrerollnumb) {
        //                             $dsecondIsLarger = true;
        //                             $dupdateattcknmb = "UPDATE attacks SET attacker_number = '$dnewrandomNumber'  WHERE attacker = '$attacker' AND defender = '$defender'";
        //                             $conn->query($dupdateattcknmb);
        //                             break; // Terminate the loop
        //                         }
        //                         else{
        //                             echo " Attacker again lost the by low attack in '$trial' reroll! ";
        //                         }
        //                     }
        //                     if ($dsecondIsLarger) {
        //                         echo " Finally! '$attacker' won in the $dtrial Re-Roll against the defender. ";
        //                         $asecondIsLarger = false;
        //                         for ($atrial = 1; $atrial <= $trial; $atrial++) {
        //                             if($atrial == 1){
        //                                 echo " '$defender' has been offered for RE-ROLL now. ";
        //                             }
        //                             else{
        //                                 echo "Again '$defender' has been offered for RE-ROLL. ";
        //                             }
        //                             $anewrandomNumber = mt_rand(1, 20);
        //                             echo " Generating defence for defender in '$atrial' reroll";
        //                             $adefenderrerollnumb = $row['attacker_number'];
        //                             // echo " Defender number in which defender won: '$adefenderrerollnumb'";
        //                             if ($anewrandomNumber > $adefenderrerollnumb) {
        //                                 $asecondIsLarger = true;
        //                                 $aupdateattcknmb = "UPDATE attacks SET defender_number = '$anewrandomNumber'  WHERE attacker = '$attacker' AND defender = '$defender'";
        //                                 $conn->query($aupdateattcknmb);
        //                                 break; // Terminate the loop
        //                             }
        //                             else{
        //                                 echo " Defender again lost the by low attack in '$trial' reroll! ";
        //                             }
        //                         }
        //                         if ($asecondIsLarger) {
        //                             echo " Finally! '$defender' won in the $atrial Re-Roll against the attacker. ";
        //                             $dfsecondIsLarger = false;
        //                             for ($dftrial = 1; $dftrial <= $dtrial; $dftrial++) {
        //                                 if($dftrial == 1){
        //                                     echo " '$attacker' has been offered for RE-ROLL now. ";
        //                                 }
        //                                 else{
        //                                     echo "Again '$attacker' has been offered for RE-ROLL. ";
        //                                 }
        //                                 $dfnewrandomNumber = mt_rand(1, 20);
        //                                 echo " Generating attack for Attacker in '$dftrial' reroll";
        //                                 $dfdefenderrerollnumb = $row['defender_number'];
        //                                 // echo " Defender number in which defender won: '$dfdefenderrerollnumb'";
        //                                 if ($dfnewrandomNumber > $dfdefenderrerollnumb) {
        //                                     $dfsecondIsLarger = true;
        //                                     $dfupdateattcknmb = "UPDATE attacks SET attacker_number = '$dfnewrandomNumber'  WHERE attacker = '$attacker' AND defender = '$defender'";
        //                                     $conn->query($dfupdateattcknmb);
        //                                     break; // Terminate the loop
        //                                 }
        //                                 else{
        //                                     echo " Attacker again lost the by low attack in '$dftrial' reroll! ";
        //                                 }
        //                             }
        //                             if ($asecondIsLarger) {
        //                             echo " Finally! '$attacker' won in the $dftrial Re-Roll against the attacker. ";
        //                             }
        //                             else{
        //                                 echo " '$attacker' has no more RE-ROLLS left to attack back.";
        //                             }
                                    
        //                         }
        //                         else{
        //                             echo " '$attacker' has no more RE-ROLLS left to attack back.";
        //                         }
        //                     }
        //                     else{
        //                         echo " In all Re-Rolls the '$attacker' couldn't against defender. Now '$defender' is the final WINNER! ";
        //                     }
        //                 } else {
        //                     echo " In all Re-Rolls the '$defender' couldn't win the attack. Now '$attacker' is the final WINNER! ";
        //                 }
        //             }
        //             else{
        //                 echo " Attacker or Defender Health is below 0 for RE-Roll! ";
        //             }
        //         }
        //         else{
        //             if($randomNumber1 > $randomNumber2){
        //             $getdefenderhealth  = $row['defender_health'];
        //             $getdefenderhealth -= 1;
        //             $timestampFromDatabase = time();
        //             $timestampAfter2Hours = strtotime('+2 hours', $timestampFromDatabase); 
        //             $formattedTimestamp = date('Y-m-d H:i:s', $timestampAfter2Hours);
        //             $updatehealth = "UPDATE attacks SET defender_health = '$getdefenderhealth', defender_last_updated = '$formattedTimestamp' WHERE attacker = '$attacker' AND defender = '$defender'";
        //             $conn->query($updatehealth);
        //                 echo " '$attacker' either hits or misses!";
        //                 // STEP 3 CALIING for defender
        //             if($getdefenderhealth > 0 ){
        //                 $maxTrials = 3;
        //                 $secondIsLarger = false;
        //                 for ($trial = 1; $trial <= $maxTrials; $trial++) {
        //                     if($trial == 1){
        //                         echo " '$defender' has been offered for RE-ROLL. ";
        //                     }
        //                     else{
        //                         echo " Again '$defender' has been offered for RE-ROLL. ";
        //                     }
        //                     $newrandomNumber = mt_rand(1, 20);
        //                     echo " Generating defence for defender in '$trial' reroll";
        //                     if ($newrandomNumber > $randomNumber1) {
        //                         $secondIsLarger = true;
        //                         $updateattcknmb = "UPDATE attacks SET defender_number = '$newrandomNumber'  WHERE attacker = '$attacker' AND defender = '$defender'";
        //                         $conn->query($updateattcknmb);
        //                         break; // Terminate the loop
        //                     }
        //                     else{
        //                         echo " Defender again lost the by low defence in '$trial' reroll! ";
        //                     }
        //                 }
        //                 if ($secondIsLarger) {
        //                     echo " Finally! '$defender' won in the $trial Re-Roll against the attacker. ";
        //                     $dmaxTrials = 3;
        //                     $dsecondIsLarger = false;
        //                     for ($dtrial = 1; $dtrial <= $dmaxTrials; $dtrial++) {
        //                         if($dtrial == 1){
        //                             echo " '$attacker' has been offered for RE-ROLL now. ";
        //                         }
        //                         else{
        //                             echo "Again '$attacker' has been offered for RE-ROLL. ";
        //                         }
        //                         $dnewrandomNumber = mt_rand(1, 20);
        //                         echo " Generating attack for Attacker in '$dtrial' reroll";
        //                         $attackerrerollnumb = $row['defender_number'];
        //                         // echo " Attacker number in which attacker won: '$attackerrerollnumb'";
        //                         if ($dnewrandomNumber > $attackerrerollnumb) {
        //                             $dsecondIsLarger = true;
        //                             $dupdateattcknmb = "UPDATE attacks SET attacker_number = '$dnewrandomNumber'  WHERE attacker = '$attacker' AND defender = '$defender'";
        //                             $conn->query($dupdateattcknmb);
        //                             break; // Terminate the loop
        //                         }
        //                         else{
        //                             echo " Attacker again lost the by low attack in '$trial' reroll! ";
        //                         }
        //                     }
        //                     if ($dsecondIsLarger) {
        //                         echo " Finally! '$attacker' won in the $dtrial Re-Roll against the defender. ";
        //                         $asecondIsLarger = false;
        //                         for ($atrial = 1; $atrial <= $trial; $atrial++) {
        //                             if($atrial == 1){
        //                                 echo " '$defender' has been offered for RE-ROLL now. ";
        //                             }
        //                             else{
        //                                 echo "Again '$defender' has been offered for RE-ROLL. ";
        //                             }
        //                             $anewrandomNumber = mt_rand(1, 20);
        //                             echo " Generating defence for defender in '$atrial' reroll";
        //                             $adefenderrerollnumb = $row['attacker_number'];
        //                             // echo " Defender number in which defender won: '$adefenderrerollnumb'";
        //                             if ($anewrandomNumber > $adefenderrerollnumb) {
        //                                 $asecondIsLarger = true;
        //                                 $aupdateattcknmb = "UPDATE attacks SET defender_number = '$anewrandomNumber'  WHERE attacker = '$attacker' AND defender = '$defender'";
        //                                 $conn->query($aupdateattcknmb);
        //                                 break; // Terminate the loop
        //                             }
        //                             else{
        //                                 echo " Defender again lost the by low attack in '$trial' reroll! ";
        //                             }
        //                         }
        //                         if ($asecondIsLarger) {
        //                             echo " Finally! '$defender' won in the $atrial Re-Roll against the attacker. ";
        //                             $dfsecondIsLarger = false;
        //                             for ($dftrial = 1; $dftrial <= $dtrial; $dftrial++) {
        //                                 if($dftrial == 1){
        //                                     echo " '$attacker' has been offered for RE-ROLL now. ";
        //                                 }
        //                                 else{
        //                                     echo "Again '$attacker' has been offered for RE-ROLL. ";
        //                                 }
        //                                 $dfnewrandomNumber = mt_rand(1, 20);
        //                                 echo " Generating attack for Attacker in '$dftrial' reroll";
        //                                 $dfdefenderrerollnumb = $row['defender_number'];
        //                                 // echo " Defender number in which defender won: '$dfdefenderrerollnumb'";
        //                                 if ($dfnewrandomNumber > $dfdefenderrerollnumb) {
        //                                     $dfsecondIsLarger = true;
        //                                     $dfupdateattcknmb = "UPDATE attacks SET attacker_number = '$dfnewrandomNumber'  WHERE attacker = '$attacker' AND defender = '$defender'";
        //                                     $conn->query($dfupdateattcknmb);
        //                                     break; // Terminate the loop
        //                                 }
        //                                 else{
        //                                     echo " Attacker again lost the by low attack in '$dftrial' reroll! ";
        //                                 }
        //                             }
        //                             if ($asecondIsLarger) {
        //                             echo " Finally! '$attacker' won in the $dftrial Re-Roll against the attacker. ";
        //                             }
        //                             else{
        //                                 echo " '$attacker' has no more RE-ROLLS left to attack back.";
        //                             }
                                    
        //                         }
        //                         else{
        //                             echo " '$attacker' has no more RE-ROLLS left to attack back.";
        //                         }
        //                     }
        //                     else{
        //                         echo " In all Re-Rolls the '$attacker' couldn't against defender. Now '$defender' is the final WINNER! ";
        //                     }
        //                 } else {
        //                     echo " In all Re-Rolls the '$defender' couldn't win the attack. Now '$attacker' is the final WINNER! ";
        //                 }
        //             }
        //             else{
        //                 echo " Attacker or Defender Health is below 0 for RE-Roll! ";
        //             }
        //             }
        //             else{
        //             $getattackerhealth  = $row['attacker_health'];
        //             $getattackerhealth -= 1;
        //             $timestampFromDatabase = time();
        //             $timestampAfter2Hours = strtotime('+2 hours', $timestampFromDatabase); 
        //             $formattedTimestamp = date('Y-m-d H:i:s', $timestampAfter2Hours);
        //             $updatehealth = "UPDATE attacks SET attacker_health = '$getattackerhealth', attacker_last_updated = '$formattedTimestamp' WHERE attacker = '$attacker' AND defender = '$defender'";
        //             $conn->query($updatehealth);
        //             echo " Attacker Lost the Attack due to low Attack!";
        //                 echo " '$defender' won by greater defence";
        //             // STEP 3 CALIING for attacker
        //             if($getattackerhealth > 0 ){
        //                 $maxTrials = 3;
        //                 $secondIsLarger = false;
        //                 for ($trial = 1; $trial <= $maxTrials; $trial++) {
        //                     if($trial == 1){
        //                         echo " '$attacker' has been offered for RE-ROLL. ";
        //                     }
        //                     else{
        //                         echo "Again '$attacker' has been offered for RE-ROLL. ";
        //                     }
        //                     $newrandomNumber = mt_rand(1, 20);
        //                     echo " Generating attack for Attacker in '$trial' reroll"; 
        //                     if ($newrandomNumber > $randomNumber2) {
        //                         $secondIsLarger = true;
        //                         $updateattcknmb = "UPDATE attacks SET attacker_number = '$newrandomNumber'  WHERE attacker = '$attacker' AND defender = '$defender'";
        //                         $conn->query($updateattcknmb);
        //                         break; // Terminate the loop
        //                     }
        //                     else{
        //                         echo " Attacker again lost the by low attack in '$trial' reroll! ";
        //                     }
        //                 }
        //                 if ($secondIsLarger) {
        //                     echo " Finally! '$attacker' won in the $trial Re-Roll against the defender. ";
        //                     $dmaxTrials = 3;
        //                     $dsecondIsLarger = false;
        //                     for ($dtrial = 1; $dtrial <= $dmaxTrials; $dtrial++) {
        //                         if($dtrial == 1){
        //                             echo " '$defender' has been offered for RE-ROLL now. ";
        //                         }
        //                         else{
        //                             echo "Again '$defender' has been offered for RE-ROLL. ";
        //                         }
        //                         $dnewrandomNumber = mt_rand(1, 20);
        //                         echo " Generating defence for defender in '$dtrial' reroll";
        //                         $attackerrerollnumb = $row['attacker_number'];
        //                         // echo " Attacker number in which attacker won: '$attackerrerollnumb'";
        //                         if ($dnewrandomNumber > $attackerrerollnumb) {
        //                             $dsecondIsLarger = true;
        //                             $dupdateattcknmb = "UPDATE attacks SET defender_number = '$dnewrandomNumber'  WHERE attacker = '$attacker' AND defender = '$defender'";
        //                             $conn->query($dupdateattcknmb);
        //                             break; // Terminate the loop
        //                         }
        //                         else{
        //                             echo " Defender again lost the by low defence in '$trial' reroll! ";
        //                         }
        //                     }
        //                     if ($dsecondIsLarger) {
        //                         echo " Finally! '$defender' won in the $dtrial Re-Roll against the attacker. ";
        //                         $asecondIsLarger = false;
        //                         for ($atrial = 1; $atrial <= $trial; $atrial++) {
        //                             if($atrial == 1){
        //                                 echo " '$attacker' has been offered for RE-ROLL now. ";
        //                             }
        //                             else{
        //                                 echo "Again '$attacker' has been offered for RE-ROLL. ";
        //                             }
        //                             $anewrandomNumber = mt_rand(1, 20);
        //                             echo " Generating attack for Attacker in '$atrial' reroll";
        //                             $adefenderrerollnumb = $row['defender_number'];
        //                             // echo " Defender number in which defender won: '$adefenderrerollnumb'";
        //                             if ($anewrandomNumber > $adefenderrerollnumb) {
        //                                 $asecondIsLarger = true;
        //                                 $aupdateattcknmb = "UPDATE attacks SET attacker_number = '$anewrandomNumber'  WHERE attacker = '$attacker' AND defender = '$defender'";
        //                                 $conn->query($aupdateattcknmb);
        //                                 break; // Terminate the loop
        //                             }
        //                             else{
        //                                 echo " Attacker again lost the by low attack in '$trial' reroll! ";
        //                             }
        //                         }
        //                         if ($asecondIsLarger) {
        //                             echo " Finally! '$attacker' won in the $atrial Re-Roll against the defender. ";
        //                             $dfsecondIsLarger = false;
        //                             for ($dftrial = 1; $dftrial <= $dtrial; $dftrial++) {
        //                                 if($dftrial == 1){
        //                                     echo " '$defender' has been offered for RE-ROLL now. ";
        //                                 }
        //                                 else{
        //                                     echo "Again '$defender' has been offered for RE-ROLL. ";
        //                                 }
        //                                 $dfnewrandomNumber = mt_rand(1, 20);
        //                                 echo " Generating defence for defender in '$dftrial' reroll";
        //                                 $dfdefenderrerollnumb = $row['attacker_number'];
        //                                 // echo " Defender number in which defender won: '$dfdefenderrerollnumb'";
        //                                 if ($dfnewrandomNumber > $dfdefenderrerollnumb) {
        //                                     $dfsecondIsLarger = true;
        //                                     $dfupdateattcknmb = "UPDATE attacks SET defender_number = '$dfnewrandomNumber'  WHERE attacker = '$attacker' AND defender = '$defender'";
        //                                     $conn->query($dfupdateattcknmb);
        //                                     break; // Terminate the loop
        //                                 }
        //                                 else{
        //                                     echo " Defender again lost the by low defence in '$dftrial' reroll! ";
        //                                 }
        //                             }
        //                             if ($asecondIsLarger) {
        //                             echo " Finally! '$defender' won in the $dftrial Re-Roll against the attacker. ";
        //                             }
        //                             else{
        //                                 echo " '$defender' has no more RE-ROLLS left to attack back.";
        //                             }
                                    
        //                         }
        //                         else{
        //                             echo " '$attacker' has no more RE-ROLLS left to attack back.";
        //                         }
        //                     }
        //                     else{
        //                         echo " In all Re-Rolls the '$defender' couldn't against defender. Now '$attacker' is the final WINNER! ";
        //                     }
        //                 } else {
        //                     echo " In all Re-Rolls the '$attacker' couldn't win the attack. Now '$defender' is the final WINNER! ";
        //                 }
        //             }
        //             else{
        //                 echo " Attacker or Defender Health is below 0 for RE-Roll! ";
        //             }
        //             }
                    
        //         }
                
            
        // }
        }
        } else {
            echo " Error inserting new row: " . $conn->error;
        }
    }
// }

	$conn->close();
}
else{
    echo "Fail begin here!!!";
}
?>



<?php
// echo "hello world";
// echo "hello-world";
// for ($i = 1; $i <= 10000000; $i++) {
//     echo "<div style='display: none;'> Iteration $i!!! </div>";
// }
// echo "The function has completed after at least 1 minute of processing.";

?>