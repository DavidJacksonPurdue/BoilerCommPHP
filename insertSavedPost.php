<?php
// Get the q parameter from URL
require('dbCredentials.php');
$q = $_REQUEST["q"];
$inputArray = explode("_", $q);
$userId = $inputArray[0];
$postId = $inputArray[1];

global $hst;
global $usr;
global $pswrd;
global $db;

// Opens a connection to a MySQL server
$connection=mysqli_connect ($hst, $usr, $pswrd, $db);
if (!$connection) {
    die('Not connected : ' . mysqli_connect_error());
}

$query = "SELECT MAX(savedPostID) FROM saved";
$result = mysqli_query($connection, $query);
if (!$result) {
    echo "could not get maxID";
}

$row = @mysqli_fetch_assoc($result);
$savedPostId = $row['MAX(savedPostID)'] + 1;


// Query for inserting a new user
$query = "INSERT INTO saved (savedPostID, userID, postID)
          VALUES 
          ('".$savedPostId."',
           '".$userId."',
           '".$postId."')";

// Insert the user and recive a response
if ($connection->query($query) === TRUE) {
    echo "Inserted saved post successfully";
} else {
    echo "Error inserting saved post " . $connection->error;
}
?>