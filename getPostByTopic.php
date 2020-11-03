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

// create an array for storing data
$query = "select p.postID, p.userID, p.topicID, t.topicName, p.postName, p.postText, p.postImage, p.postDate, us.userName, (ifnull(u.upvoteCount,0) - ifnull(d.downvoteCount, 0)) as voteTotal
from post p left JOIN (SELECT postID, count(postID) as upvoteCount FROM upvote GROUP BY postID) u ON p.postID = u.postID
left JOIN (SELECT postID, count(postID) as downvoteCount FROM downvote GROUP BY postID) d ON p.postID = d.postID
join user us on p.userID = us.userID
join topic t on p.topicID = t.topicID where p.topicID = '".$q."'";

//creating an statement with the query
$result = mysqli_query($conn, $query);
if (!$result) {
    die('Invalid query: ' . mysqli_error($conn));
}
header('Access-Control-Allow-Origin: *');
header("Content-type: text/xml");

// Start XML file, echo parent node
echo "<?xml version='1.0' ?>";
echo '<posts>';
$ind=0;
// Iterate through the rows, printing XML nodes for each
while ($row = @mysqli_fetch_assoc($result)){
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
    echo '/>';
    $ind = $ind + 1;
}

// End XML file
echo '</posts>';
$conn->close();
