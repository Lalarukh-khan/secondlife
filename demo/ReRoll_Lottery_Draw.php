<?php

 $host = "localhost";
 $username = "id20395489_rum_lot";
 $password = ")X1Z^w^Y+XG8Ob/6";
 $dbname = "id20395489_lottery";
 
  
 try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    
    
    
    
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
    
    $date = date_create('now', timezone_open('America/Los_Angeles'));
    $date = date_format($date, 'Y-m-d H:i:s');
    
    
    $incr = $conn->prepare("
    UPDATE `lottery_db` 
    SET `wins` = `wins` + 1
    WHERE TIMESTAMPDIFF(day,`timestamp`,'".$date."' ) < 14 AND `wins` < 3
    ORDER BY RAND() 
    LIMIT 3");
     $incr->execute();
     
    }
    
    
    
    
     catch(PDOException $e) {    
    echo "Connection failed: " . $e->getMessage();
    }
 

?>