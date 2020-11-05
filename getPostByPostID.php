<?php
//these are the server details
//the username is root by default in case of xampp
//password is nothing by default
//and lastly we have the database named android. if your database name is different you have to change it
require('dbCredentials.php');
$q = $_REQUEST["q"];
$inputArray = explode("_", $q);
$userID = $inputArray[0];
$postID = $inputArray[1];
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
$query1 = "select postID from saved where userID = '".$userID."'";

//this is our sql query
$query2 = "select p.postID, p.userID, p.topicID, t.topicName, p.postName, p.postText, p.postImage, p.postDate, us.userName, (ifnull(u.upvoteCount,0) - ifnull(d.downvoteCount, 0)) as voteTotal
from post p left JOIN (SELECT postID, count(postID) as upvoteCount FROM upvote GROUP BY postID) u ON p.postID = u.postID
left JOIN (SELECT postID, count(postID) as downvoteCount FROM downvote GROUP BY postID) d ON p.postID = d.postID
join topic t on p.topicID = t.topicID
join user us on p.userID = us.userID where p.postID='".$postID."'";

//creating an statement with the query
$result1 = mysqli_query($connection, $query1);
$resultArr = array();
if (!$result1) {
    die('Invalid query: ' . mysqli_error($connection));
}

while ($row1 = @mysqli_fetch_assoc($result1)) {
    array_push($resultArr, $row1['postID']);
}

$result2 = mysqli_query($connection, $query2);
if (!$result1) {
    die('Invalid query: ' . mysqli_error($connection));
}




header('Access-Control-Allow-Origin: *');
header("Content-type: text/xml");

// Start XML file, echo parent node
echo "<?xml version='1.0' ?>";
echo '<posts>';
$ind=0;
// Iterate through the rows, printing XML nodes for each
while ($row = @mysqli_fetch_assoc($result2)){
    // Add to XML document node
    echo '<post ';
    echo 'postID="' . $row['postID'] . '" ';
    echo 'userID="' . $row['userID'] . '" ';
    echo 'topicID="' . $row['topicID'] . '" ';
    echo 'topicName="' . $row['topicName'] . '" ';
    echo 'postName="' . $row['postName'] . '" ';
    echo 'postText="' . $row['postText'] . '" ';
    echo 'postDate="' . $row['postDate'] . '" ';
    echo 'userName="' . $row['userName'] . '" ';
    echo 'voteTotal="' . $row['voteTotal'] . '" ';
    echo 'postImage="' . $row['postImage'] . '" ';
    if(in_array($row['postID'], $resultArr)){
        echo 'savedPostID="' . "true" . '" ';
    }else{
        echo 'savedPostID="'."false".'" ';
    }
    echo '/>';
    $ind = $ind + 1;
}

// End XML file
echo '</posts>';
$connection->close();
