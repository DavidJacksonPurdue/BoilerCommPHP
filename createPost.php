<?php
require('dbCredentials.php');
global $hst;
global $usr;
global $pswrd;
global $db;
// get the q parameter from URL
// Added a comment for the sake of testing the github
$file = $_POST;
$data = json_decode(file_get_contents('php://input'), true);
$q = $_REQUEST["q"];
$inputArray = explode("_", $q);
$userId = $inputArray[0];
$postId = $inputArray[1];
$topicId = $inputArray[2];
$postName = $inputArray[3];
$postText = $inputArray[4];
$postDate = $inputArray[5];
$connection=mysqli_connect ($hst, $usr, $pswrd, $db);
if (!$connection) {
    die('Not connected : ' . mysqli_connect_error());
}

$query = "SELECT MAX(postID) FROM post";
$result = mysqli_query($connection, $query);
if (!$result) {
    echo "could not get maxID";
}

$row = @mysqli_fetch_assoc($result);
$postId = $row['MAX(postID)'] + 1;

$postImage = $data['imageString'];
if(strpos($postImage, '<<>>') === false){
    $query = "INSERT INTO post (userID, postID, topicID, postName, postText, postImage, postDate)
VALUES 
('".$userId."', '".$postId."', '".$topicId."', '".$postName."', '".$postText."', '".$postImage."', '".$postDate."')";
}else{
    $query = "INSERT INTO post (userID, postID, topicID, postName, postText, postImage, postDate)
VALUES 
('".$userId."', '".$postId."', '".$topicId."', '".$postName."', '".$postText."', 'null', '".$postDate."')";
}
$result = mysqli_query($connection, $query);
if (!$result) {
    die('Invalid query: ' . mysqli_error($connection));
}
header('Access-Control-Allow-Origin: *');
header('Content-Type: text/xml');
echo $result;
$connection->close();