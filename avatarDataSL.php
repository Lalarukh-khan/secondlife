<?php
if(isset($_GET['avatar'])) {

    $avatar_name = $_GET['avatar'];

	$password = "123";
    
    // Connect to the database
    $conn = new mysqli("localhost", "elbkmjmy_WPGXP", "1#VghAm&}-.>uS)H=", "elbkmjmy_WPGXP");
    
    // Check connection
    if ($conn->connect_error) {

        die("Connection failed: " . $conn->connect_error);

    }
    
    // Insert the avatar name into the database
    $sql = "INSERT INTO character_data (avatar_name, password) VALUES ('$avatar_name', '$password')";
    
    if ($conn->query($sql) === TRUE) {

        echo "Avatar data stored in the database successfully.";

    } else {

        echo "Error: " . $sql . "<br>" . $conn->error;

    }
    
    $conn->close();

} else {

    echo "No avatar data received.";

}
?>
