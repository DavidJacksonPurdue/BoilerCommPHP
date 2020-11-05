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
$query1 = "Select topicID from topic_following where userID = '".$userID."'";

$result1 = mysqli_query($connection, $query1);
$resultArr = array();
if (!$result1) {
    die('Invalid query: ' . mysqli_error($connection));
}

while ($row1 = @mysqli_fetch_assoc($result1)) {
    array_push($resultArr, $row1['topicID']);
}

if(in_array($topicID, $resultArr)){
    echo "Error inserting user: " . $connection->error;
}else{
    $query2 = "INSERT INTO topic_following (userID, topicID)
          VALUES 
          ('".$userID."',
           '".$topicID."')";
    if ($connection->query($query2) === TRUE) {
        echo "Inserted user succesfully";
    } else {
        echo "Error inserting user: " . $connection->error;
    }
}
