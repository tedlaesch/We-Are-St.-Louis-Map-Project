
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
if(isset($_POST['submit']) && $_FILES['userImage']['name'] != ''){
    // get information of the file.
    $file = $_FILES['userImage'];
    // get the name of the file
    $fileName = $_FILES['userImage']['name'];
    // get the temporary location of the file
    $fileTempLocation = $_FILES['userImage']['tmp_name'];
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
                //header("Location: insert.php? Success!");
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
        echo '"' . $fileName . '"';
    }
}



/**************************************** SQL CONNECTION ***********************************/
$conn = new mysqli("localhost", "root", "", "map"); //Establish connection to database "map"
$posttext = isset($_POST["userText"]) ? $_POST["userText"] : ""; //Get "usertext from form"
$postlocationlat = isset($_POST['coordlat']) ? $_POST['coordlat'] : 0.0;
$postlocationlng = isset($_POST["coordlng"]) ? $_POST["coordlng"] : 0.0;
$postalttext = isset($_POST["altText"]) ? $_POST["altText"] : "";
$postImage = isset($fileDestination) ? $fileDestination : "";
$approved = 0;
// Push everything into a new row in the table
$insert = "INSERT INTO posts (text, image, alt, lat, lng, approved) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($insert);
$stmt->bind_param("ssssss", $posttext, $postImage, $postalttext, $postlocationlat, $postlocationlng, $approved);
$stmt->execute();

$stmt->close();
$conn->close(); //closes connection

//echo "Lat: " . $postlocationlat . "\n";
//echo "Lng: " . $postlocationlng;

header("Location: map.php?0");
?>