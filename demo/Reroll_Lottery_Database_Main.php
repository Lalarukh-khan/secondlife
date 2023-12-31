<?php
 $host = "localhost";
 
//  put in the username and password of the database into these variables between the quotes.
 $username = "";
 $password = "";
 $dbname = "";
 
  
 try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    
    
     if ($_SERVER["REQUEST_METHOD"] == "POST") {     
     $json = file_get_contents('php://input');
     $data = json_decode($json);
     
     $uuid = $data -> uuid;
     $name = $data -> name;
     $rolls = $data -> rolls;
     $health = $data -> health;
     $race = $data -> race;
     $mpoints = $data -> mod_points;
     $atk_mod = $data -> attack_mod;
     $ev_mod = $data -> evade_mod;
     $st_mod = $data -> stealth_mod;
     $dt_mod = $data -> detect_mod;
     $str_mod = $data -> strength_mod;
     $fin = $data -> finalize;
     $cmd = $data -> cmd;
     
     
     
     $date = date_create('now', timezone_open('America/Los_Angeles'));
     $date = date_format($date, 'Y-m-d H:i:s');
     
     
     
     $datetime = new DateTime();
     $timezone = new DateTimeZone('America/Los_Angeles');
     $datetime->setTimezone($timezone);
     $datetime = $datetime->format('YYYY-MM-DD hh:mm:ss.mmm'); // for example
     
    if($cmd === "POST"){
       
      $chk =  "SELECT * FROM lottery_db WHERE uuid =  '".$uuid."'";

      $result = $conn -> query($chk);
      
      if ($result -> rowCount() > 0) 
      {
        // 'Found!'
        
    $stmt = $conn->prepare("SELECT `uuid`,`wins`,`health`, `race`, `mod_points`, `evade_mod`, `attack_mod`, `stealth_mod`, `detect_mod`, `strength_mod`, finalize  FROM `lottery_db` WHERE `uuid` = '".$uuid."'");

    
    $stmt->execute(); 
    $rresult = $stmt->fetchALL(\PDO::FETCH_ASSOC); // when getting multiple rows use fetchALL
    echo "Found|".json_encode($rresult);
        
        
        
      } 
    
    else 
    {
        // not found
         echo "Not Found";
    $sql = "INSERT INTO lottery_db (uuid,name,timestamp,wins, health,race, mod_points,attack_mod,evade_mod,stealth_mod,detect_mod,strength_mod,finalize) VALUES ('".$uuid."','".$name."','".$date."','".$rolls."', '".$health."','".$race."','".$mpoints."','".$atk_mod."','".$ev_mod."','".$st_mod."','".$dt_mod."','".$str_mod."','".$fin."')"; 
     $conn -> query($sql);
   
    }
        
    
    } // cmd = post
    
    else if($cmd === "UPDATE"){
        
        $sql = "UPDATE lottery_db SET `timestamp` = '".$date."', `health` = '".$health."', `race` = '".$race."', `mod_points` = '".$mpoints."',`attack_mod` = '".$atk_mod."',`evade_mod` = '".$ev_mod."',`stealth_mod` = '".$st_mod."',`detect_mod` = '".$dt_mod."',`strength_mod` = '".$str_mod."',`finalize` = '".$fin."' WHERE `uuid` = '".$uuid."'";  
     $conn -> query($sql);
     
      $stmt = $conn->prepare("SELECT `wins`  FROM `lottery_db` WHERE `uuid` = '".$uuid."'");

    
    $stmt->execute(); 
    $rresult = $stmt->fetchALL(\PDO::FETCH_ASSOC); // when getting multiple rows use fetchALL
    echo "Updated|".json_encode($rresult);
        
    }
    
    else if($cmd === "ROLLS_UPDATE"){
        
        $sql = "UPDATE lottery_db SET `wins` = '".$rolls."' WHERE `uuid` = '".$uuid."'";   
     $conn -> query($sql);
     
      $stmt = $conn->prepare("SELECT `wins`  FROM `lottery_db` WHERE `uuid` = '".$uuid."'");

    
    $stmt->execute(); 
    $rresult = $stmt->fetchALL(\PDO::FETCH_ASSOC); // when getting multiple rows use fetchALL
    echo "Rolls_Updated|".json_encode($rresult);
        
    }
    
    else if($cmd === "RESET"){
        
    $sql = "DELETE FROM lottery_db WHERE `uuid` = '".$uuid."'";  
     $conn -> query($sql);
      echo "database_reset";
     
      
        
    }
    
    else
    {
    
    //$query = $conn->prepare("SELECT `uuid` FROM `lottery_db` WHERE `uuid` = '".$uuid."'");
    //$query->execute();    
    //$result = $query->fetch(\PDO::FETCH_ASSOC);
    //echo json_encode($result);
    
    //echo "\n\n";
    
    //$rand = $conn->prepare("SELECT `uuid` FROM `lottery_db` ORDER BY RAND() LIMIT 3");
   // $rand->execute(); 
   // $rresult = $rand->fetchALL(\PDO::FETCH_ASSOC); // when getting multiple rows use fetchALL
   // echo json_encode($rresult);
    
   // echo "\n\n";
    
   // $rand = $conn->prepare("SELECT `uuid`, `timestamp` FROM `lottery_db` WHERE TIMESTAMPDIFF(day,`timestamp`,'".$date."' ) < 7  ORDER BY RAND() LIMIT 3");
   // $rand->execute(); 
   // $rresult = $rand->fetchALL(\PDO::FETCH_ASSOC); // when getting multiple rows use fetchALL
   // echo json_encode($rresult);
    
   // $incr = $conn->prepare("
   // UPDATE `lottery_db` 
   // SET `wins` = `wins` + 1
   // WHERE TIMESTAMPDIFF(day,`timestamp`,'".$date."' ) < 7
   // ORDER BY RAND() 
   // LIMIT 3");
   //  $incr->execute();
     
    }
    
     }
    
    
    } catch(PDOException $e) {    
    echo "Connection failed: " . $e->getMessage();
    }
 

 
 	 
?>