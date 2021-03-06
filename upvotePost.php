<?php
// Get the q parameter from URL
require('dbCredentials.php');
$q = $_REQUEST["q"];
$inputArray = explode("_", $q);
$post_id = $inputArray[0];
$user_id = $inputArray[1];

// Created by Nick Rosato
// CS307: Fall 2020

global $hst;
global $usr;
global $pswrd;
global $db;

// Opens a connection to a MySQL server
$connection=mysqli_connect ($hst, $usr, $pswrd, $db);
if (!$connection) {
    die('Not connected : ' . mysqli_connect_error());
}

$query = "SELECT MAX(upvoteID) FROM upvote";
$result = mysqli_query($connection, $query);
if (!$result) {
    echo "could not get upvote_id";
}
$row = @mysqli_fetch_assoc($result);

$upvote_id = $row['MAX(upvoteID)'] + 1;


// Query for inserting a new user
$query = "INSERT INTO upvote (upvoteID, postID, userID)
          VALUES 
          ('".$upvote_id."',
           '".$post_id."',
           '".$user_id."')";

// Insert the user and recive a response
if ($connection->query($query) === TRUE) {
    echo "Updated upvotes successfully";
} else {
    echo "Error updating upvotes " . $connection->error;
}
?>