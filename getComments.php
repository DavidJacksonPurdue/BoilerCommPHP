<?php
require('dbCredentials.php');
function parseToXML($htmlStr)
{
    $xmlStr=str_replace('<','&lt;',$htmlStr);
    $xmlStr=str_replace('>','&gt;',$xmlStr);
    $xmlStr=str_replace('"','&quot;',$xmlStr);
    $xmlStr=str_replace("'",'&#39;',$xmlStr);
    $xmlStr=str_replace("&",'&amp;',$xmlStr);
    return $xmlStr;
}
$q = $_REQUEST["q"];


global $hst;
global $usr;
global $pswrd;
global $db;


$connection=mysqli_connect ($hst, $usr, $pswrd, $db);
if (!$connection) {
    die('Not connected : ' . mysqli_connect_error());
}






$query = "SELECT c.*, u.userName
FROM (comment c)
LEFT JOIN user u ON c.userID = u.userID
WHERE c.postID = '".$q."'
ORDER BY c.commentID ASC";

$result = mysqli_query($connection, $query);
if (!$result) {
    die('Invalid query: ' . mysqli_error($connection));
}


header('Access-Control-Allow-Origin: *');
header("Content-type: text/xml");

// Start XML file, echo parent node
echo "<?xml version='1.0' ?>";
echo '<comments>';
$ind=0;
// Iterate through the rows, printing XML nodes for each
while ($row = @mysqli_fetch_assoc($result)){
    // Add to XML document node
    echo '<comment ';
    echo 'commentID="' . $row['commentID'] . '" ';
    echo 'postID="' . $row['postID'] . '" ';
    echo 'parentCommentID="' . $row['parentCommentID'] . '" ';
    echo 'commentText="' . $row['commentText'] . '" ';
    echo 'userName="' . $row['userName'] . '" ';
    echo 'userID="' . $row['userID'] . '" ';
    echo 'dateSubmitted="' . $row['dateSubmitted'] . '" ';
    echo '/>';
    $ind = $ind + 1;
}

// End XML file
echo '</comments>';
$connection->close();




