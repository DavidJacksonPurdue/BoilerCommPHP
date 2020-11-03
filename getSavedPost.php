<?php
//these are the server details
//the username is root by default in case of xampp
//password is nothing by default
//and lastly we have the database named android. if your database name is different you have to change it
require('dbCredentials.php');
$q = $_REQUEST["q"];

global $hst;
global $usr;
global $pswrd;
global $db;

//creating a new connection object using mysqli
$conn=mysqli_connect ($hst, $usr, $pswrd, $db);

//if there is some error connecting to the database
//with die we will stop the further execution by displaying a message causing the error
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//if everything is fine

//creating an array for storing the data
$posts = array();

//this is our sql query
/*$sql = "select p.postID, p.userID as authorID, p.topicID, t.topicName, p.postName, p.postText, p.postImage, p.postDate, us.userName, u.upvoteCount
from post p
join saved s on s.postID = p.postID 
left JOIN (SELECT postID, count(postID) as upvoteCount 
FROM upvote GROUP BY postID) u ON p.postID = u.postID join topic t on p.topicID = t.topicID 
join user us on p.userID = us.userID where s.userID=".$q;*/


$sql = "select p.postID, p.userID, p.topicID, t.topicName, p.postName, p.postText, p.postImage, p.postDate, us.userName, (ifnull(u.upvoteCount,0) - ifnull(d.downvoteCount, 0)) as voteTotal
from saved s join  post p on s.postID = p.postID left JOIN (SELECT postID, count(postID) as upvoteCount FROM upvote GROUP BY postID) u ON p.postID = u.postID
left JOIN (SELECT postID, count(postID) as downvoteCount FROM downvote GROUP BY postID) d ON p.postID = d.postID
join topic t on p.topicID = t.topicID
join user us on p.userID = us.userID where p.userID='".$q."'";

//creating an statement with the query
$stmt = $conn->prepare($sql);

//executing that statement
$stmt->execute();

//binding results for that statement
$stmt->bind_result($postID, $authorID, $topicID, $topicName, $postName, $postText, $postImage, $postDate, $userName, $upvoteCount);

//looping through all the records
while($stmt->fetch()){

    //pushing fetched data in an array
    $temp = [
        'authorID'=>$authorID,
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
