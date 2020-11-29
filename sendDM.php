<?php
require('dbCredentials.php');
$q = $_REQUEST["q"];
$inputArray = explode("_", $q);
$dmid = $inputArray[0];
$time = $inputArray[1];
$uid1 = $inputArray[2];
$uid2 = $inputArray[3];
$body = $inputArray[4];

global $hst;
global $usr;
global $pswrd;
global $db;

// Opens a connection to a MySQL server
$connection=mysqli_connect ($hst, $usr, $pswrd, $db);
if (!$connection) {
    die('Not connected : ' . mysqli_connect_error());
}
if($dmid == NULL){
    $query1 = "SELECT MAX(dm_id) FROM dm";
    $result1 = mysqli_query($connection, $query1);
    if (!$result1) {
        return "could not get maxID";
    }

    $row1 = @mysqli_fetch_assoc($result1);
    $dmid = $row1['MAX(dm_id)'] + 1;
    $query2 = "INSERT INTO dm (dm_id, user_id_one, user_id_two) VALUES('".$dmid."', '".$uid1."', '".$uid2."')";
    $result2 = mysqli_query($connection, $query2);
    if (!$result2) {
        return "could not get maxID";
    }
}




$query3 = "SELECT MAX(dm_message_id) FROM dm_messages";
$result3 = mysqli_query($connection, $query3);
if (!$result3) {
    return "could not get maxID";
}

$row2 = @mysqli_fetch_assoc($result3);
$dmMessageID = $row2['MAX(dm_message_id)'] + 1;

$query4 = "INSERT INTO dm_messages (dm_message_id, body, user_id, time, dm_id_fk)
          VALUES 
          ('".$dmMessageID."',
           '".$body."',
           '".$uid1."',
           '".$time."',
           '".$dmid."')";

// Insert the user and recive a response
if ($connection->query($query4) === TRUE) {
    echo $query4;
} else {
    echo "Error inserting comment: " . $connection->error;
}