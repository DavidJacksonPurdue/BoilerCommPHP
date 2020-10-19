<?php
$file = $_POST;
$data = json_decode(file_get_contents('php://input'), true);
$q = $_REQUEST["q"];
$inputArray = explode("_", $q);
$userId = $inputArray[0];
$userName = $inputArray[1];
$firstName = $inputArray[2];
$lastName = $inputArray[3];
$email = $inputArray[4];
$password = $inputArray[5];
$con = mysqli_connect('127.0.0.1', "root", 'Alivanzavashin1', 'cs307_testdb_schema');
if (!$con) {
    die('Not connected : ' . mysqli_connect_error());
}
$profilePic = $data['imageString'];
if(strpos($profilePic, '<<>>') !== false){
    $query = "UPDATE user 
SET
    userName = '" . $userName . "',
    firstName = '" . $firstName . "',
    lastName = '" . $lastName . "',
    email = '" . $email . "',
    PASSWORD = '" . $password . "'
WHERE
    userID = " . $userId;
}else{
    $query = "UPDATE user 
SET
    userName = '" . $userName . "',
    firstName = '" . $firstName . "',
    lastName = '" . $lastName . "',
    email = '" . $email . "',
    PASSWORD = '" . $password . "',
    profilePic = '" . $profilePic . "'
WHERE
    userID = " . $userId;
}
$result = mysqli_query($con, $query);
if (!$result) {
    die('Invalid query: ' . mysqli_error($con));
}
header('Access-Control-Allow-Origin: *');
header('Content-Type: text/xml');
echo $result;
$con->close();