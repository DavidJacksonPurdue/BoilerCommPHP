<?php
require ('dbCredentials.php');
$q = $_REQUEST["q"];
global $hst;
global $usr;
global $pswrd;
global $db;
// File written by Elijah Heminger
// CS 307: Will retrive posts associated with a topic ID
// A topic Id will be needed as a parameter
$conn=mysqli_connect ($hst, $usr, $pswrd, $db);
// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}

$posts = array();

// create an array for storing data
$sql = "select p.postID, p.userID, p.topicID, t.topicName, p.postName, p.postText, p.postImage, ".
"p.postDate from post p join topic t on p.topicID = t.topicID where p.topicID=".$q;

// create a statement with the query
$stmt = $conn->prepare($sql);
// execute the query
$stmt->execute();
// bind the results for that statement
$stmt->bind_result($userID, $postID, $topicID, $topicName, $postName, $postText, $postImage, $postDate);

// loop through all the records
while ($stmt->fetch()) {
	// pushing fetched data in an array
    $temp = [
        'userID'=>$userID,
        'postID'=>$postID,
        'topicID'=>$topicID,
        'topicName'=>$topicName,
        'postName'=>$postName,
        'postText'=>$postText,
        'postImage'=>$postImage,
        'postDate'=>$postDate
    ];
	//pushing the array inside the hero array
    array_push($posts, $temp);
}

//displaying the data in json format
$array_final = json_encode($posts, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

echo $array_final;
?>