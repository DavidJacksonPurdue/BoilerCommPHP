<?php
//these are the server details
//the username is root by default in case of xampp
//password is nothing by default
//and lastly we have the database named android. if your database name is different you have to change it
require('dbCredentials.php');
$q = $_REQUEST["q"];
$inputArray = explode("_", $q);
$user = $inputArray[0];
$blocked = $inputArray[1];

global $hst;
global $usr;
global $pswrd;
global $db;


//creating a new connection object using mysqli
$connection=mysqli_connect ($hst, $usr, $pswrd, $db);

//if there is some error connecting to the database
//with die we will stop the further execution by displaying a message causing the error
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

//this is our sql query
$query = "select * from blocking where userID= '".$user."' and blockedID= '".$blocked."'" ;

//creating an statement with the query
$result = mysqli_query($connection, $query);

if (!$result) {
    echo "FAIL";
    die('Invalid query: ' . mysqli_error($connection));
}

$exists = mysqli_num_rows($result);

if ($exists >= 1) {
    $query = "delete from blocking where '".$user."' = userID and '".$blocked."' = blockedID";
    echo "TRUE";
}
else {
    $query = "insert into blocking (userID, blockedID) VALUES 
    ('".$user."', '".$blocked."')";
    echo "FALSE";
}

$result = mysqli_query($connection, $query);

if (!$result) {
    echo "FAIL";
    die('Invalid query: ' . mysqli_error($connection));
}

$connection->close();
