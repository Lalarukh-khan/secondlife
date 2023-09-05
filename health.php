<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
if (isset($_GET['avatar']) && isset($_GET['player'])) {
    $attacker_lsl = $_GET['avatar'];
    $defender_lsl = $_GET['player'];
    $attacker = "";
    $defender = "";
    if($attacker_lsl == "Lalarukh Resident"){
        $attacker = $_GET['avatar'];
        $defender = $_GET['player'];
    }
    elseif($attacker_lsl == "Ember Ronas"){
        $attacker = $_GET['player'];
        $defender = $_GET['avatar'];
    }
    else{
        $attacker = $_GET['avatar'];
        $defender = $_GET['player'];
    }

	$conn = new mysqli("localhost", "elbkmjmy_WPGXP", "1#VghAm&}-.>uS)H=", "elbkmjmy_WPGXP");
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}

$query = "SELECT * FROM detects WHERE attacker = '$attacker' AND defender = '$defender'";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    // echo "Defender and Attacker already exist";
    while ($row = $result->fetch_assoc()) {
            $attackerpoint = $row['attacker_points'] + 1;
            $randomNumber = mt_rand(1, 20);
            $randomNumber1 = $randomNumber + $attackerpoint;
            $randomNumber2 = mt_rand(1, 20);
            echo "Your number is: ".$randomNumber1;
            echo " The player number is: ".$randomNumber2;
            $updateQuery = "UPDATE detects SET attacker_number = '$randomNumber1', defender_number = '$randomNumber2', attacker_points = '$attackerpoint' WHERE attacker = '$attacker' AND defender = '$defender'";
            $conn->query($updateQuery);
            if($randomNumber1 < 5){
                echo " You Lost the detect due to low detection!";
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
                        $newrandomNumber = mt_rand(1, 20);
                        echo " Generating detection for you in '$trial' reroll"; 
                        if ($newrandomNumber > $randomNumber2) {
                            $secondIsLarger = true;
                            $updateattcknmb = "UPDATE detects SET attacker_number = '$newrandomNumber'  WHERE attacker = '$attacker' AND defender = '$defender'";
                            $conn->query($updateattcknmb);
                            break; // Terminate the loop
                        }
                        else{
                            echo " You have again lost the by low detection in '$trial' reroll! ";
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
                            $dnewrandomNumber = mt_rand(1, 20);
                            echo " Generating detection for player in '$dtrial' reroll";
                            $attackerrerollnumb = $row['attacker_number'];
                            // echo " Attacker number in which attacker won: '$attackerrerollnumb'";
                            if ($dnewrandomNumber > $attackerrerollnumb) {
                                $dsecondIsLarger = true;
                                $dupdateattcknmb = "UPDATE detects SET defender_number = '$dnewrandomNumber'  WHERE attacker = '$attacker' AND defender = '$defender'";
                                $conn->query($dupdateattcknmb);
                                break; // Terminate the loop
                            }
                            else{
                                echo " Player again lost the by low detection in '$trial' reroll! ";
                            }
                        }
                        if ($dsecondIsLarger) {
                            echo " Finally! '$defender' won in the $dtrial Re-Roll against you. ";
                            $asecondIsLarger = false;
                            for ($atrial = 1; $atrial <= $trial; $atrial++) {
                                if($atrial == 1){
                                    echo " '$attacker' has been offered for RE-ROLL now. ";
                                }
                                else{
                                    echo "Again '$attacker' has been offered for RE-ROLL. ";
                                }
                                $anewrandomNumber = mt_rand(1, 20);
                                echo " Generating detection for you in '$atrial' reroll";
                                $adefenderrerollnumb = $row['defender_number'];
                                // echo " Defender number in which defender won: '$adefenderrerollnumb'";
                                if ($anewrandomNumber > $adefenderrerollnumb) {
                                    $asecondIsLarger = true;
                                    $aupdateattcknmb = "UPDATE detects SET attacker_number = '$anewrandomNumber'  WHERE attacker = '$attacker' AND defender = '$defender'";
                                    $conn->query($aupdateattcknmb);
                                    break; // Terminate the loop
                                }
                                else{
                                    echo " you have again lost the by low detection in '$trial' reroll! ";
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
                                    echo " Generating detectin for player in '$dftrial' reroll";
                                    $dfdefenderrerollnumb = $row['attacker_number'];
                                    // echo " Defender number in which defender won: '$dfdefenderrerollnumb'";
                                    if ($dfnewrandomNumber > $dfdefenderrerollnumb) {
                                        $dfsecondIsLarger = true;
                                        $dfupdateattcknmb = "UPDATE detects SET defender_number = '$dfnewrandomNumber'  WHERE attacker = '$attacker' AND defender = '$defender'";
                                        $conn->query($dfupdateattcknmb);
                                        break; // Terminate the loop
                                    }
                                    else{
                                        echo " Player again lost the by low defence in '$dftrial' reroll! ";
                                    }
                                }
                                if ($asecondIsLarger) {
                                echo " Finally! '$defender' won in the $dftrial Re-Roll against you. ";
                                }
                                else{
                                    echo " '$defender' has no more RE-ROLLS left to detect back.";
                                }
                                
                            }
                            else{
                                echo " '$attacker' has no more RE-ROLLS left to detect back.";
                            }
                        }
                        else{
                            echo " In all Re-Rolls the '$defender' couldn't against player. Now '$attacker' is the final WINNER! ";
                        }
                    } else {
                        echo " In all Re-Rolls the '$attacker' couldn't win the detection. Now '$defender' is the final WINNER! ";
                    }
                
            }
            elseif($randomNumber2 < 5){
                echo " Player Lost due to low detection!";
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
                        $newrandomNumber = mt_rand(1, 20);
                        echo " Generating detection for player in '$trial' reroll";
                        if ($newrandomNumber > $randomNumber1) {
                            $secondIsLarger = true;
                            $updateattcknmb = "UPDATE detects SET defender_number = '$newrandomNumber'  WHERE attacker = '$attacker' AND defender = '$defender'";
                            $conn->query($updateattcknmb);
                            break; // Terminate the loop
                        }
                        else{
                            echo " Player again lost the by low detection in '$trial' reroll! ";
                        }
                    }
                    if ($secondIsLarger) {
                        echo " Finally! '$defender' won in the $trial Re-Roll against You. ";
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
                            echo " Generating detection for you in '$dtrial' reroll";
                            $attackerrerollnumb = $row['defender_number'];
                            // echo " Attacker number in which attacker won: '$attackerrerollnumb'";
                            if ($dnewrandomNumber > $attackerrerollnumb) {
                                $dsecondIsLarger = true;
                                $dupdateattcknmb = "UPDATE detects SET attacker_number = '$dnewrandomNumber'  WHERE attacker = '$attacker' AND defender = '$defender'";
                                $conn->query($dupdateattcknmb);
                                break; // Terminate the loop
                            }
                            else{
                                echo " You again lost the by low detection in '$trial' reroll! ";
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
                                $anewrandomNumber = mt_rand(1, 20);
                                echo " Generating detection for player in '$atrial' reroll";
                                $adefenderrerollnumb = $row['attacker_number'];
                                // echo " Defender number in which defender won: '$adefenderrerollnumb'";
                                if ($anewrandomNumber > $adefenderrerollnumb) {
                                    $asecondIsLarger = true;
                                    $aupdateattcknmb = "UPDATE detects SET defender_number = '$anewrandomNumber'  WHERE attacker = '$attacker' AND defender = '$defender'";
                                    $conn->query($aupdateattcknmb);
                                    break; // Terminate the loop
                                }
                                else{
                                    echo " Player again lost the by low detection in '$trial' reroll! ";
                                }
                            }
                            if ($asecondIsLarger) {
                                echo " Finally! '$defender' won in the $atrial Re-Roll against you. ";
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
                                        $dfupdateattcknmb = "UPDATE detects SET attacker_number = '$dfnewrandomNumber'  WHERE attacker = '$attacker' AND defender = '$defender'";
                                        $conn->query($dfupdateattcknmb);
                                        break; // Terminate the loop
                                    }
                                    else{
                                        echo " You again lost the by low detection in '$dftrial' reroll! ";
                                    }
                                }
                                if ($asecondIsLarger) {
                                echo " Finally! '$attacker' won in the $dftrial Re-Roll against you. ";
                                }
                                else{
                                    echo " '$attacker' has no more RE-ROLLS left to detect back.";
                                }
                                
                            }
                            else{
                                echo " '$attacker' has no more RE-ROLLS left to detect back.";
                            }
                        }
                        else{
                            echo " In all Re-Rolls the '$attacker' couldn't against player. Now '$defender' is the final WINNER! ";
                        }
                    } else {
                        echo " In all Re-Rolls the '$defender' couldn't win the detection. Now '$attacker' is the final WINNER! ";
                    }
                
            }
            else{
                if($randomNumber1 > $randomNumber2){
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
                        $newrandomNumber = mt_rand(1, 20);
                        echo " Generating detection for player in '$trial' reroll";
                        if ($newrandomNumber > $randomNumber1) {
                            $secondIsLarger = true;
                            $updateattcknmb = "UPDATE detects SET defender_number = '$newrandomNumber'  WHERE attacker = '$attacker' AND defender = '$defender'";
                            $conn->query($updateattcknmb);
                            break; // Terminate the loop
                        }
                        else{
                            echo " Player again lost the by low detection in '$trial' reroll! ";
                        }
                    }
                    if ($secondIsLarger) {
                        echo " Finally! '$defender' won in the $trial Re-Roll against You. ";
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
                            echo " Generating detection for you in '$dtrial' reroll";
                            $attackerrerollnumb = $row['defender_number'];
                            // echo " Attacker number in which attacker won: '$attackerrerollnumb'";
                            if ($dnewrandomNumber > $attackerrerollnumb) {
                                $dsecondIsLarger = true;
                                $dupdateattcknmb = "UPDATE detects SET attacker_number = '$dnewrandomNumber'  WHERE attacker = '$attacker' AND defender = '$defender'";
                                $conn->query($dupdateattcknmb);
                                break; // Terminate the loop
                            }
                            else{
                                echo " You again lost the by low detection in '$trial' reroll! ";
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
                                $anewrandomNumber = mt_rand(1, 20);
                                echo " Generating detection for player in '$atrial' reroll";
                                $adefenderrerollnumb = $row['attacker_number'];
                                // echo " Defender number in which defender won: '$adefenderrerollnumb'";
                                if ($anewrandomNumber > $adefenderrerollnumb) {
                                    $asecondIsLarger = true;
                                    $aupdateattcknmb = "UPDATE detects SET defender_number = '$anewrandomNumber'  WHERE attacker = '$attacker' AND defender = '$defender'";
                                    $conn->query($aupdateattcknmb);
                                    break; // Terminate the loop
                                }
                                else{
                                    echo " Player again lost the by low detection in '$trial' reroll! ";
                                }
                            }
                            if ($asecondIsLarger) {
                                echo " Finally! '$defender' won in the $atrial Re-Roll against you. ";
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
                                        $dfupdateattcknmb = "UPDATE detects SET attacker_number = '$dfnewrandomNumber'  WHERE attacker = '$attacker' AND defender = '$defender'";
                                        $conn->query($dfupdateattcknmb);
                                        break; // Terminate the loop
                                    }
                                    else{
                                        echo " You again lost the by low detection in '$dftrial' reroll! ";
                                    }
                                }
                                if ($asecondIsLarger) {
                                echo " Finally! '$attacker' won in the $dftrial Re-Roll against you. ";
                                }
                                else{
                                    echo " '$attacker' has no more RE-ROLLS left to detect back.";
                                }
                                
                            }
                            else{
                                echo " '$attacker' has no more RE-ROLLS left to detect back.";
                            }
                        }
                        else{
                            echo " In all Re-Rolls the '$attacker' couldn't against player. Now '$defender' is the final WINNER! ";
                        }
                    } else {
                        echo " In all Re-Rolls the '$defender' couldn't win the detection. Now '$attacker' is the final WINNER! ";
                    }
                }
                else{
                echo "  You have Lost the detection due to low detect!";
                    echo "  '$defender' won by greater detection";
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
                        $newrandomNumber = mt_rand(1, 20);
                        echo " Generating detection for you in '$trial' reroll"; 
                        if ($newrandomNumber > $randomNumber2) {
                            $secondIsLarger = true;
                            $updateattcknmb = "UPDATE detects SET attacker_number = '$newrandomNumber'  WHERE attacker = '$attacker' AND defender = '$defender'";
                            $conn->query($updateattcknmb);
                            break; // Terminate the loop
                        }
                        else{
                            echo " You have again lost the by low detection in '$trial' reroll! ";
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
                            $dnewrandomNumber = mt_rand(1, 20);
                            echo " Generating detection for player in '$dtrial' reroll";
                            $attackerrerollnumb = $row['attacker_number'];
                            // echo " Attacker number in which attacker won: '$attackerrerollnumb'";
                            if ($dnewrandomNumber > $attackerrerollnumb) {
                                $dsecondIsLarger = true;
                                $dupdateattcknmb = "UPDATE detects SET defender_number = '$dnewrandomNumber'  WHERE attacker = '$attacker' AND defender = '$defender'";
                                $conn->query($dupdateattcknmb);
                                break; // Terminate the loop
                            }
                            else{
                                echo " Player again lost the by low detection in '$trial' reroll! ";
                            }
                        }
                        if ($dsecondIsLarger) {
                            echo " Finally! '$defender' won in the $dtrial Re-Roll against you. ";
                            $asecondIsLarger = false;
                            for ($atrial = 1; $atrial <= $trial; $atrial++) {
                                if($atrial == 1){
                                    echo " '$attacker' has been offered for RE-ROLL now. ";
                                }
                                else{
                                    echo "Again '$attacker' has been offered for RE-ROLL. ";
                                }
                                $anewrandomNumber = mt_rand(1, 20);
                                echo " Generating detection for you in '$atrial' reroll";
                                $adefenderrerollnumb = $row['defender_number'];
                                // echo " Defender number in which defender won: '$adefenderrerollnumb'";
                                if ($anewrandomNumber > $adefenderrerollnumb) {
                                    $asecondIsLarger = true;
                                    $aupdateattcknmb = "UPDATE detects SET attacker_number = '$anewrandomNumber'  WHERE attacker = '$attacker' AND defender = '$defender'";
                                    $conn->query($aupdateattcknmb);
                                    break; // Terminate the loop
                                }
                                else{
                                    echo " you have again lost the by low detection in '$trial' reroll! ";
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
                                    echo " Generating detectin for player in '$dftrial' reroll";
                                    $dfdefenderrerollnumb = $row['attacker_number'];
                                    // echo " Defender number in which defender won: '$dfdefenderrerollnumb'";
                                    if ($dfnewrandomNumber > $dfdefenderrerollnumb) {
                                        $dfsecondIsLarger = true;
                                        $dfupdateattcknmb = "UPDATE detects SET defender_number = '$dfnewrandomNumber'  WHERE attacker = '$attacker' AND defender = '$defender'";
                                        $conn->query($dfupdateattcknmb);
                                        break; // Terminate the loop
                                    }
                                    else{
                                        echo " Player again lost the by low defence in '$dftrial' reroll! ";
                                    }
                                }
                                if ($asecondIsLarger) {
                                echo " Finally! '$defender' won in the $dftrial Re-Roll against you. ";
                                }
                                else{
                                    echo " '$defender' has no more RE-ROLLS left to detect back.";
                                }
                                
                            }
                            else{
                                echo " '$attacker' has no more RE-ROLLS left to detect back.";
                            }
                        }
                        else{
                            echo " In all Re-Rolls the '$defender' couldn't against player. Now '$attacker' is the final WINNER! ";
                        }
                    } else {
                        echo " In all Re-Rolls the '$attacker' couldn't win the detection. Now '$defender' is the final WINNER! ";
                    }
                }
                
            }
            
    }
} else {
    // Row doesn't exist, insert a new row
    $insertQuery = "INSERT INTO detects (attacker, defender) VALUES ('$attacker', '$defender')";
    
    if ($conn->query($insertQuery) === TRUE) {
        $newRowId = $conn->insert_id;

    // SQL query to select the newly inserted row by its ID
    $selectQuery = "SELECT * FROM detects WHERE id = $newRowId";
    $result = $conn->query($selectQuery);
    if ($result->num_rows > 0) {
         while ($row = $result->fetch_assoc()) {
            $attackerpoint = $row['attacker_points'] + 1;
            $randomNumber = mt_rand(1, 20);
            $randomNumber1 = $randomNumber + $attackerpoint;
            $randomNumber2 = mt_rand(1, 20);
            echo "Your number is: ".$randomNumber1;
            echo " The player number is: ".$randomNumber2;
            $updateQuery = "UPDATE detects SET attacker_number = '$randomNumber1', defender_number = '$randomNumber2', attacker_points = '$attackerpoint' WHERE attacker = '$attacker' AND defender = '$defender'";
            $conn->query($updateQuery);
            if($randomNumber1 < 5){
                echo " You Lost the detect due to low detection!";
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
                        $newrandomNumber = mt_rand(1, 20);
                        echo " Generating detection for you in '$trial' reroll"; 
                        if ($newrandomNumber > $randomNumber2) {
                            $secondIsLarger = true;
                            $updateattcknmb = "UPDATE detects SET attacker_number = '$newrandomNumber'  WHERE attacker = '$attacker' AND defender = '$defender'";
                            $conn->query($updateattcknmb);
                            break; // Terminate the loop
                        }
                        else{
                            echo " You have again lost the by low detection in '$trial' reroll! ";
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
                            $dnewrandomNumber = mt_rand(1, 20);
                            echo " Generating detection for player in '$dtrial' reroll";
                            $attackerrerollnumb = $row['attacker_number'];
                            // echo " Attacker number in which attacker won: '$attackerrerollnumb'";
                            if ($dnewrandomNumber > $attackerrerollnumb) {
                                $dsecondIsLarger = true;
                                $dupdateattcknmb = "UPDATE detects SET defender_number = '$dnewrandomNumber'  WHERE attacker = '$attacker' AND defender = '$defender'";
                                $conn->query($dupdateattcknmb);
                                break; // Terminate the loop
                            }
                            else{
                                echo " Player again lost the by low detection in '$trial' reroll! ";
                            }
                        }
                        if ($dsecondIsLarger) {
                            echo " Finally! '$defender' won in the $dtrial Re-Roll against you. ";
                            $asecondIsLarger = false;
                            for ($atrial = 1; $atrial <= $trial; $atrial++) {
                                if($atrial == 1){
                                    echo " '$attacker' has been offered for RE-ROLL now. ";
                                }
                                else{
                                    echo "Again '$attacker' has been offered for RE-ROLL. ";
                                }
                                $anewrandomNumber = mt_rand(1, 20);
                                echo " Generating detection for you in '$atrial' reroll";
                                $adefenderrerollnumb = $row['defender_number'];
                                // echo " Defender number in which defender won: '$adefenderrerollnumb'";
                                if ($anewrandomNumber > $adefenderrerollnumb) {
                                    $asecondIsLarger = true;
                                    $aupdateattcknmb = "UPDATE detects SET attacker_number = '$anewrandomNumber'  WHERE attacker = '$attacker' AND defender = '$defender'";
                                    $conn->query($aupdateattcknmb);
                                    break; // Terminate the loop
                                }
                                else{
                                    echo " you have again lost the by low detection in '$trial' reroll! ";
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
                                    echo " Generating detectin for player in '$dftrial' reroll";
                                    $dfdefenderrerollnumb = $row['attacker_number'];
                                    // echo " Defender number in which defender won: '$dfdefenderrerollnumb'";
                                    if ($dfnewrandomNumber > $dfdefenderrerollnumb) {
                                        $dfsecondIsLarger = true;
                                        $dfupdateattcknmb = "UPDATE detects SET defender_number = '$dfnewrandomNumber'  WHERE attacker = '$attacker' AND defender = '$defender'";
                                        $conn->query($dfupdateattcknmb);
                                        break; // Terminate the loop
                                    }
                                    else{
                                        echo " Player again lost the by low defence in '$dftrial' reroll! ";
                                    }
                                }
                                if ($asecondIsLarger) {
                                echo " Finally! '$defender' won in the $dftrial Re-Roll against you. ";
                                }
                                else{
                                    echo " '$defender' has no more RE-ROLLS left to detect back.";
                                }
                                
                            }
                            else{
                                echo " '$attacker' has no more RE-ROLLS left to detect back.";
                            }
                        }
                        else{
                            echo " In all Re-Rolls the '$defender' couldn't against player. Now '$attacker' is the final WINNER! ";
                        }
                    } else {
                        echo " In all Re-Rolls the '$attacker' couldn't win the detection. Now '$defender' is the final WINNER! ";
                    }
                
            }
            elseif($randomNumber2 < 5){
                echo " Player Lost due to low detection!";
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
                        $newrandomNumber = mt_rand(1, 20);
                        echo " Generating detection for player in '$trial' reroll";
                        if ($newrandomNumber > $randomNumber1) {
                            $secondIsLarger = true;
                            $updateattcknmb = "UPDATE detects SET defender_number = '$newrandomNumber'  WHERE attacker = '$attacker' AND defender = '$defender'";
                            $conn->query($updateattcknmb);
                            break; // Terminate the loop
                        }
                        else{
                            echo " Player again lost the by low detection in '$trial' reroll! ";
                        }
                    }
                    if ($secondIsLarger) {
                        echo " Finally! '$defender' won in the $trial Re-Roll against You. ";
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
                            echo " Generating detection for you in '$dtrial' reroll";
                            $attackerrerollnumb = $row['defender_number'];
                            // echo " Attacker number in which attacker won: '$attackerrerollnumb'";
                            if ($dnewrandomNumber > $attackerrerollnumb) {
                                $dsecondIsLarger = true;
                                $dupdateattcknmb = "UPDATE detects SET attacker_number = '$dnewrandomNumber'  WHERE attacker = '$attacker' AND defender = '$defender'";
                                $conn->query($dupdateattcknmb);
                                break; // Terminate the loop
                            }
                            else{
                                echo " You again lost the by low detection in '$trial' reroll! ";
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
                                $anewrandomNumber = mt_rand(1, 20);
                                echo " Generating detection for player in '$atrial' reroll";
                                $adefenderrerollnumb = $row['attacker_number'];
                                // echo " Defender number in which defender won: '$adefenderrerollnumb'";
                                if ($anewrandomNumber > $adefenderrerollnumb) {
                                    $asecondIsLarger = true;
                                    $aupdateattcknmb = "UPDATE detects SET defender_number = '$anewrandomNumber'  WHERE attacker = '$attacker' AND defender = '$defender'";
                                    $conn->query($aupdateattcknmb);
                                    break; // Terminate the loop
                                }
                                else{
                                    echo " Player again lost the by low detection in '$trial' reroll! ";
                                }
                            }
                            if ($asecondIsLarger) {
                                echo " Finally! '$defender' won in the $atrial Re-Roll against you. ";
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
                                        $dfupdateattcknmb = "UPDATE detects SET attacker_number = '$dfnewrandomNumber'  WHERE attacker = '$attacker' AND defender = '$defender'";
                                        $conn->query($dfupdateattcknmb);
                                        break; // Terminate the loop
                                    }
                                    else{
                                        echo " You again lost the by low detection in '$dftrial' reroll! ";
                                    }
                                }
                                if ($asecondIsLarger) {
                                echo " Finally! '$attacker' won in the $dftrial Re-Roll against you. ";
                                }
                                else{
                                    echo " '$attacker' has no more RE-ROLLS left to detect back.";
                                }
                                
                            }
                            else{
                                echo " '$attacker' has no more RE-ROLLS left to detect back.";
                            }
                        }
                        else{
                            echo " In all Re-Rolls the '$attacker' couldn't against player. Now '$defender' is the final WINNER! ";
                        }
                    } else {
                        echo " In all Re-Rolls the '$defender' couldn't win the detection. Now '$attacker' is the final WINNER! ";
                    }
                
            }
            else{
                if($randomNumber1 > $randomNumber2){
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
                        $newrandomNumber = mt_rand(1, 20);
                        echo " Generating detection for player in '$trial' reroll";
                        if ($newrandomNumber > $randomNumber1) {
                            $secondIsLarger = true;
                            $updateattcknmb = "UPDATE detects SET defender_number = '$newrandomNumber'  WHERE attacker = '$attacker' AND defender = '$defender'";
                            $conn->query($updateattcknmb);
                            break; // Terminate the loop
                        }
                        else{
                            echo " Player again lost the by low detection in '$trial' reroll! ";
                        }
                    }
                    if ($secondIsLarger) {
                        echo " Finally! '$defender' won in the $trial Re-Roll against You. ";
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
                            echo " Generating detection for you in '$dtrial' reroll";
                            $attackerrerollnumb = $row['defender_number'];
                            // echo " Attacker number in which attacker won: '$attackerrerollnumb'";
                            if ($dnewrandomNumber > $attackerrerollnumb) {
                                $dsecondIsLarger = true;
                                $dupdateattcknmb = "UPDATE detects SET attacker_number = '$dnewrandomNumber'  WHERE attacker = '$attacker' AND defender = '$defender'";
                                $conn->query($dupdateattcknmb);
                                break; // Terminate the loop
                            }
                            else{
                                echo " You again lost the by low detection in '$trial' reroll! ";
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
                                $anewrandomNumber = mt_rand(1, 20);
                                echo " Generating detection for player in '$atrial' reroll";
                                $adefenderrerollnumb = $row['attacker_number'];
                                // echo " Defender number in which defender won: '$adefenderrerollnumb'";
                                if ($anewrandomNumber > $adefenderrerollnumb) {
                                    $asecondIsLarger = true;
                                    $aupdateattcknmb = "UPDATE detects SET defender_number = '$anewrandomNumber'  WHERE attacker = '$attacker' AND defender = '$defender'";
                                    $conn->query($aupdateattcknmb);
                                    break; // Terminate the loop
                                }
                                else{
                                    echo " Player again lost the by low detection in '$trial' reroll! ";
                                }
                            }
                            if ($asecondIsLarger) {
                                echo " Finally! '$defender' won in the $atrial Re-Roll against you. ";
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
                                        $dfupdateattcknmb = "UPDATE detects SET attacker_number = '$dfnewrandomNumber'  WHERE attacker = '$attacker' AND defender = '$defender'";
                                        $conn->query($dfupdateattcknmb);
                                        break; // Terminate the loop
                                    }
                                    else{
                                        echo " You again lost the by low detection in '$dftrial' reroll! ";
                                    }
                                }
                                if ($asecondIsLarger) {
                                echo " Finally! '$attacker' won in the $dftrial Re-Roll against you. ";
                                }
                                else{
                                    echo " '$attacker' has no more RE-ROLLS left to detect back.";
                                }
                                
                            }
                            else{
                                echo " '$attacker' has no more RE-ROLLS left to detect back.";
                            }
                        }
                        else{
                            echo " In all Re-Rolls the '$attacker' couldn't against player. Now '$defender' is the final WINNER! ";
                        }
                    } else {
                        echo " In all Re-Rolls the '$defender' couldn't win the detection. Now '$attacker' is the final WINNER! ";
                    }
                }
                else{
                echo "  You have Lost the detection due to low detect!";
                    echo "  '$defender' won by greater detection";
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
                        $newrandomNumber = mt_rand(1, 20);
                        echo " Generating detection for you in '$trial' reroll"; 
                        if ($newrandomNumber > $randomNumber2) {
                            $secondIsLarger = true;
                            $updateattcknmb = "UPDATE detects SET attacker_number = '$newrandomNumber'  WHERE attacker = '$attacker' AND defender = '$defender'";
                            $conn->query($updateattcknmb);
                            break; // Terminate the loop
                        }
                        else{
                            echo " You have again lost the by low detection in '$trial' reroll! ";
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
                            $dnewrandomNumber = mt_rand(1, 20);
                            echo " Generating detection for player in '$dtrial' reroll";
                            $attackerrerollnumb = $row['attacker_number'];
                            // echo " Attacker number in which attacker won: '$attackerrerollnumb'";
                            if ($dnewrandomNumber > $attackerrerollnumb) {
                                $dsecondIsLarger = true;
                                $dupdateattcknmb = "UPDATE detects SET defender_number = '$dnewrandomNumber'  WHERE attacker = '$attacker' AND defender = '$defender'";
                                $conn->query($dupdateattcknmb);
                                break; // Terminate the loop
                            }
                            else{
                                echo " Player again lost the by low detection in '$trial' reroll! ";
                            }
                        }
                        if ($dsecondIsLarger) {
                            echo " Finally! '$defender' won in the $dtrial Re-Roll against you. ";
                            $asecondIsLarger = false;
                            for ($atrial = 1; $atrial <= $trial; $atrial++) {
                                if($atrial == 1){
                                    echo " '$attacker' has been offered for RE-ROLL now. ";
                                }
                                else{
                                    echo "Again '$attacker' has been offered for RE-ROLL. ";
                                }
                                $anewrandomNumber = mt_rand(1, 20);
                                echo " Generating detection for you in '$atrial' reroll";
                                $adefenderrerollnumb = $row['defender_number'];
                                // echo " Defender number in which defender won: '$adefenderrerollnumb'";
                                if ($anewrandomNumber > $adefenderrerollnumb) {
                                    $asecondIsLarger = true;
                                    $aupdateattcknmb = "UPDATE detects SET attacker_number = '$anewrandomNumber'  WHERE attacker = '$attacker' AND defender = '$defender'";
                                    $conn->query($aupdateattcknmb);
                                    break; // Terminate the loop
                                }
                                else{
                                    echo " you have again lost the by low detection in '$trial' reroll! ";
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
                                    echo " Generating detectin for player in '$dftrial' reroll";
                                    $dfdefenderrerollnumb = $row['attacker_number'];
                                    // echo " Defender number in which defender won: '$dfdefenderrerollnumb'";
                                    if ($dfnewrandomNumber > $dfdefenderrerollnumb) {
                                        $dfsecondIsLarger = true;
                                        $dfupdateattcknmb = "UPDATE detects SET defender_number = '$dfnewrandomNumber'  WHERE attacker = '$attacker' AND defender = '$defender'";
                                        $conn->query($dfupdateattcknmb);
                                        break; // Terminate the loop
                                    }
                                    else{
                                        echo " Player again lost the by low defence in '$dftrial' reroll! ";
                                    }
                                }
                                if ($asecondIsLarger) {
                                echo " Finally! '$defender' won in the $dftrial Re-Roll against you. ";
                                }
                                else{
                                    echo " '$defender' has no more RE-ROLLS left to detect back.";
                                }
                                
                            }
                            else{
                                echo " '$attacker' has no more RE-ROLLS left to detect back.";
                            }
                        }
                        else{
                            echo " In all Re-Rolls the '$defender' couldn't against player. Now '$attacker' is the final WINNER! ";
                        }
                    } else {
                        echo " In all Re-Rolls the '$attacker' couldn't win the detection. Now '$defender' is the final WINNER! ";
                    }
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