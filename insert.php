<?php 
    $conn = new mysqli("localhost", "root", "", "information"); //Establish connection to database "information"
    $posttext = $_POST["userText"]; //Get "usertext from form"
    $insert = "INSERT INTO information (posttext) VALUES ('$posttext')"; //variable that inserts what we want

    if ($conn->query($insert) === TRUE) { //inserts into table
        echo "New record created successfully";
      } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
      }

      $conn->close(); //closes connection
?>
<h1>DATA WAS INSERTED</h1>
