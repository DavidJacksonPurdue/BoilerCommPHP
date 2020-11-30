<?php
// Get the q parameter from URL
require('dbCredentials.php');
$q = $_REQUEST["q"];
$inputArray = explode("_", $q);
$userID = $inputArray[0];
$topicID = $inputArray[1];


global $hst;
global $usr;
global $pswrd;
global $db;

// Opens a connection to a MySQL server
$connection=mysqli_connect ($hst, $usr, $pswrd, $db);
if (!$connection) {
    die('Not connected : ' . mysqli_connect_error());
}
$query1 = "Select * from topic_following where userID = '".$userID."' and '".$topicID."' = topicID";

$result1 = mysqli_query($connection, $query1);

if (!$result1) {
    echo "FAIL";
    die('Invalid query: ' . mysqli_error($connection));
}

$exists = mysqli_num_rows($result1);

if ($exists >= 1) {
    $query2 = "delete from topic_following where '".$userID."' = userID and '".$topicID."' = topicID";
    echo "TRUE";
}

else {
    $query2 = "insert into topic_following (userID, topicID) VALUES 
    ('".$userID."', '".$topicID."')";
    echo "FALSE";
}

$result2 = mysqli_query($connection, $query2);

if (!$result2) {
    echo "FAIL";
    die('Invalid query: ' . mysqli_error($connection));
}

$connection->close();
