<?php
// Step 1: Contact the Website (LSL Script)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['attacker']) && isset($_POST['avatars'])) {
    $attacker = $_POST['attacker'];
    $avatars = explode(",", $_POST['avatars']);
    
    storeAttackData($attacker, $avatars);
    
    pauseHealing($attacker, 7200);
    
    sendToHUD($attacker, "Healing paused for 2 hours.");
}

// Step 2: Perform the Math
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['attacker'])) {
    $attacker = $_POST['attacker'];
    $avatars = getStoredAttackData($attacker);
    
    foreach ($avatars as $avatar) {
        $health = getHealth($avatar);
        if ($health === 0) {
            sendToGeneralChat("Player $avatar has no health.");
        }
    }
    
    $attackerRandomNumber = rand(1, 20);
    $defenderRandomNumber = rand(1, 20);
    
    storeRandomNumbers($attacker, $attackerRandomNumber, $defenderRandomNumber);
    pauseHealthRegeneration($attacker, 7200);
    
    sendAlertToPlayers($attacker, "Your healing is paused for 2 hours. Do you want to attack?");
    askPlayersToAttack($attacker);
    
    if ($attackerRandomNumber < 5) {
        rerollSection($attacker);
    }
    
    $attackerAttackPoints = calculateAttackPoints($attacker);
    $attackerRandomNumber += $attackerAttackPoints;
    
    $defenderAttackPoints = calculateAttackPoints($defender);
    $defenderRandomNumber += $defenderAttackPoints;
    
    $outcome = compareNumbers($attackerRandomNumber, $defenderRandomNumber);
    
    if ($outcome === "attacker") {
        sendToHUD($attacker, "hits");
    } else {
        sendToHUD($attacker, "misses");
        rerollSection($defender);
    }
}

// Step 3: Re-Roll Catch
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['player'])) {
    $player = $_POST['player'];
    
    if (hasStoredRerolls($player)) {
        sendReRollOffer($player);
        
        if (playerAcceptsReRoll($player)) {
            $newRandomNumber = rand(1, 20);
            $storedRandomNumbers = getStoredRandomNumbers($player);
            $originalNumber = $storedRandomNumbers['attacker']; // Adjust as needed
            
            if ($newRandomNumber > $originalNumber) {
                sendToHUD($player, "hits after re-roll");
            } else {
                sendToHUD($player, "misses after re-roll");
            }
        }
    }
}
// MySQL Database Functions (Replace with your database details)
function storeAttackData($attacker, $avatars) {
	$conn = new mysqli("localhost", "elbkmjmy_WPGXP", "1#VghAm&}-.>uS)H=", "elbkmjmy_WPGXP");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    $avatarsList = implode(",", $avatars);
    $sql = "INSERT INTO attacks (attacker, avatars) VALUES ('$attacker', '$avatarsList')";
    $sql2 = "INSERT INTO players (player_name) VALUES ('$attacker')";
	$conn->query($sql2);
    
    if ($conn->query($sql) === FALSE) {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    
    $conn->close();
}
// Function to simulate player's decision to accept a re-roll offer
function playerAcceptsReRoll($player) {
    // Simulate player's decision (50% chance of accepting)
    $acceptProbability = 0.5;
    $randomValue = mt_rand() / mt_getrandmax(); // Generate a random value between 0 and 1
    
    return $randomValue <= $acceptProbability;
}

// Function to pause healing for a player
function pauseHealing($player, $duration) {
	$conn = new mysqli("localhost", "elbkmjmy_WPGXP", "1#VghAm&}-.>uS)H=", "elbkmjmy_WPGXP");
    $currentTime = time();
    $pauseUntil = $currentTime + $duration;
    
    $sql = "UPDATE players SET healing_paused_until = '$pauseUntil' WHERE player_name = '$player'";
    $conn->query($sql);
}

// Function to send a message to the player's HUD
function sendToHUD($player, $message) {
    // Send the message to the player's HUD in Second Life (LSL script)
}

// Function to retrieve stored attack data for an attacker
function getStoredAttackData($attacker) {
	$conn = new mysqli("localhost", "elbkmjmy_WPGXP", "1#VghAm&}-.>uS)H=", "elbkmjmy_WPGXP");
    $sql = "SELECT avatars FROM attacks WHERE attacker = '$attacker'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return explode(",", $row['avatars']);
    } else {
        return [];
    }
}

function compareNumbers($attackerNumber, $defenderNumber) {
    if ($attackerNumber > $defenderNumber) {
        return "attacker";
    } else {
        return "defender";
    }
}

// Function to get the health of a player
function getHealth($player) {
	$conn = new mysqli("localhost", "elbkmjmy_WPGXP", "1#VghAm&}-.>uS)H=", "elbkmjmy_WPGXP");
    $sql = "SELECT health FROM players WHERE player_name = '$player'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['health'];
    } else {
        return 0;
    }
}

// Function to send a message to the general chat
function sendToGeneralChat($message) {
    // Send the message to the general chat in Second Life (LSL script)
}

// Function to store random numbers for the attacker and defender
function storeRandomNumbers($attacker, $attackerRandom, $defenderRandom) {
    $sql = "INSERT INTO random_numbers (attacker, defender) VALUES ('$attackerRandom', '$defenderRandom')";
    
$conn = new mysqli("localhost", "elbkmjmy_WPGXP", "1#VghAm&}-.>uS)H=", "elbkmjmy_WPGXP");
    if ($conn->query($sql) === FALSE) {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Function to pause health regeneration for a player
function pauseHealthRegeneration($player, $duration) {
    $currentTime = time();
    $pauseUntil = $currentTime + $duration;
	$conn = new mysqli("localhost", "elbkmjmy_WPGXP", "1#VghAm&}-.>uS)H=", "elbkmjmy_WPGXP");
    
    $sql = "UPDATE players SET regeneration_paused_until = '$pauseUntil' WHERE player_name = '$player'";
    $conn->query($sql);
}

// Function to send an alert message to players
function sendAlertToPlayers($player, $message) {
    // Send an alert message to the players in Second Life (LSL script)
}

// Function to ask players to attack
function askPlayersToAttack($player) {
    // Ask players to attack in Second Life (LSL script)
}

// Function for the re-roll section
function rerollSection($player) {
    // Implement the re-roll section logic
}

// Function to calculate attack points for a player
function calculateAttackPoints($player) {
    // Calculate and return the attack points for the player
}

// Function to check if a player has stored re-rolls
function hasStoredRerolls($player) {
    $sql = "SELECT rerolls FROM players WHERE player_name = '$player'";
	$conn = new mysqli("localhost", "elbkmjmy_WPGXP", "1#VghAm&}-.>uS)H=", "elbkmjmy_WPGXP");
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['rerolls'] > 0;
    } else {
        return false;
    }
}

// Function to send a re-roll offer to a player
function sendReRollOffer($player) {
    // Send a re-roll offer to the player's HUD in Second Life (LSL script)
}

// Function to retrieve stored random numbers for a player
function getStoredRandomNumbers($player) {
    $sql = "SELECT attacker, defender FROM random_numbers WHERE attacker = '$player' OR defender = '$player'";
	$conn = new mysqli("localhost", "elbkmjmy_WPGXP", "1#VghAm&}-.>uS)H=", "elbkmjmy_WPGXP");
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row;
    } else {
        return ['attacker' => 0, 'defender' => 0];
    }
}
?>
