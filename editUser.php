<?php
require('dbCredentials.php');
// get the q parameter from URL
$q = $_REQUEST["q"];
$inputArray = explode("_", $q);
$userId = $inputArray[0];
$username = $inputArray[1];
$firstName = $inputArray[2];
$lastName = $inputArray[3];
$email = $inputArray[4];
$password = $inputArray[5];
$profilePic = $inputArray[6];

global $hst;
global $usr;
global $pswrd;
global $db;


$connection=mysqli_connect ($hst, $usr, $pswrd, $db);
if (!$connection) {
    die('Not connected : ' . mysqli_connect_error());
}

$query = "UPDATE user 
SET
    userName = '".$username."',
    firstName = '".$firstName."',
    lastName = '".$lastName."',
    email = '".$email."',
    PASSWORD = '".$password."'
WHERE
    userID =".$userId;


header('Access-Control-Allow-Origin: *');
header('Content-Type: text/xml');
echo '<post>';
if ($connection->query($query) === TRUE) {
    echo "Record updated successfully";
} else {
    echo "Error updating record: " . $connection->error;
}
// End XML file
echo '</post>';


$connection->close();
?>