<?php
// Get the q parameter from URL
$q = $_REQUEST["q"];
$inputArray = explode("_", $q);
$userID = $inputArray[0];
$username = $inputArray[1];
$firstName = $inputArray[2];
$lastName = $inputArray[3];
$email = $inputArray[4];
$password = $inputArray[5];
$profilePic = $inputArray[6];


// Opens a connection to a MySQL server
$connection=mysqli_connect ('127.0.0.1', "root", 'Alivanzavashin1', 'cs307_testdb_schema');
if (!$connection) {
    die('Not connected : ' . mysqli_connect_error());
}

$query = "SELECT MAX(userID) FROM user";
$result = mysqli_query($connection, $query);
if (!$result) {
    return "could not get maxID";
}

$row = @mysqli_fetch_assoc($result);
$userID = $row['MAX(userID)'] + 1;

// Query for inserting a new user
$query = "INSERT INTO user (userID, userName, firstName, lastName, email, password, profilePic)
          VALUES 
          ('".$userID."',
           '".$username."',
           '".$firstName."',
           '".$lastName."',
           '".$email."',
           '".$password."',
           '".$profilePic."')";

// Insert the user and recive a response
if ($connection->query($query) === TRUE) {
    echo "Inserted user succesfully";
} else {
    echo "Error inserting user: " . $connection->error;
}
?>