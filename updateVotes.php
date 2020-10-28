<?php
// Get the q parameter from URL
require('dbCredentials.php');
$q = $_REQUEST["q"];
$inputArray = explode("_", $q);
$upvotes = $inputArray[0];
$downvotes = $inputArray[1];
$vote_total = $inputArray[2];
$post_id = $inputArray[3];

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

$query = "SELECT $post_id FROM votes";
$result = mysqli_query($connection, $query);
if (!$result) {
    return "could not get maxID";
}

$row = @mysqli_fetch_assoc($result);


// Query for inserting a new user
$query = "INSERT INTO votes (upvotes, downvotes, vote_total, post_id)
          VALUES 
          ('".$upvotes."',
           '".$downvotes."',
           '".$vote_total."',
           '".$post_id."')";

// Insert the user and recive a response
if ($connection->query($query) === TRUE) {
    echo "Updated votes successfully";
} else {
    echo "Error updating votes " . $connection->error;
}
?>