<?php
require('dbCredentials.php');
$q = $_REQUEST["q"];
$inputArray = explode("_", $q);
$postID = $inputArray[0];
$parentID = $inputArray[1];
$commentText = $inputArray[2];
$userID = $inputArray[3];
$dateSubmitted = $inputArray[4];

global $hst;
global $usr;
global $pswrd;
global $db;

// Opens a connection to a MySQL server
$connection=mysqli_connect ($hst, $usr, $pswrd, $db);
if (!$connection) {
    die('Not connected : ' . mysqli_connect_error());
}

$query = "SELECT MAX(commentID) FROM comment";
$result = mysqli_query($connection, $query);
if (!$result) {
    return "could not get maxID";
}

$row = @mysqli_fetch_assoc($result);
$commentID = $row['MAX(commentID)'] + 1;

$query = "INSERT INTO comment (commentID, postID, parentCommentID, commentText, userID, dateSubmitted)
          VALUES 
          ('".$commentID."',
           '".$postID."',
           '".$parentID."',
           '".$commentText."',
           '".$userID."',
           '".$dateSubmitted."')";

// Insert the user and recive a response
if ($connection->query($query) === TRUE) {
    echo $commentID;
} else {
    echo "Error inserting comment: " . $connection->error;
}