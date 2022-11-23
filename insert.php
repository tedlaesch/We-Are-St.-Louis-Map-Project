
<?php

/***************************************** Text **********************************/

//Define variables and set to empty values
$userTextError="";
$userText="";

$isValid = true;
if(isset($_POST['userText'])) {
    $userText = clean_input($_POST['userText']);
    if (empty($userText)) {
        $userTextError = "Text is required";
        $isValid = false;
    } else {
        if (strlen($userText) < 0 || strlen($userText) > 280) {
            $userTextError = "Text must be between 1 and 280 characters";
            $isValid = false;
        }
    }
}

function clean_input($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}



/*************************************** FILE UPLOAD ************************************/
// if file is not uploaded in mac, go to uploads folder,
// right click - get info and set permissions to read and write

// uploads folder contains the images uploaded by users

// If submit button is clicked
if(isset($_POST['submit'])){
    // get information of the file.
    $file = $_FILES['userImage'];
    // get the name of the file
    $fileName = $_FILES['userImage']['name'];
    // get the temporary location of the file
    $fileTempLocation = $_FILES['userImage']['temp_location'];
    // get the size of the file
    $fileSize = $_FILES['userImage']['size'];
    // check for error
    $fileError = $_FILES['userImage']['error'];
    // Type of file
    $fileType = $_FILES['userImage']['type'];

    // separate the extension and the name of the file
    $fileExt = explode('.', $fileName);

    // If extension is in all caps, change it to lowercase
    // Save only the extension part of the file
    $fileActualExt = strtolower(end($fileExt));

    // Allowed file extensions
    $allowed = array('jpg', 'jpeg', 'png', 'gif', 'bmp');

    // If file extensions is in $fileActualExt, check if it is allowed
    if(in_array($fileActualExt, $allowed)){
        // If there is no error uploading the file
        if($fileError === 0){
            // Check if size is less than 1mb=1000000kb
            if($fileSize < 1000000){
                // If file name already exists,use a unique id (time format in microseconds)
                // to save file name
                $fileNameChanged = uniqid('', true).".".$fileActualExt;
                // Upload the file in fileDestination
                $fileDestination = 'uploads/'.$fileNameChanged;
                move_uploaded_file($fileTempLocation, $fileDestination);
                header("Location: insert.php? Success!");
            }
            else{
                echo "Your file is too big!";
            }
        }
        // The file cannot be uploaded
        else{
            echo "Error uploading your file!";
        }
    }
    // File extensions are not allowed
    else{
        echo "This file extension is not allowed!";
    }
}



/**************************************** SQL CONNECTION ***********************************/
$conn = new mysqli("localhost", "root", "", "information"); //Establish connection to database "information"
$posttext = $_POST["userText"]; //Get "usertext from form"
$postlocationlon = $_POST["coord[lat]"];
$postlocationlng = $_POST["coord[lng]"];
$insert = "INSERT INTO information (posttext) VALUES ('$posttext')"; //variable that inserts what we want

if ($conn->query($insert) === TRUE) { //inserts into table
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close(); //closes connection
?>

<h1>DATA WAS INSERTED</h1>
<?php
echo "Lat: " . $postlocationlon;
echo "Lng: " . $postlocationlng;
?>