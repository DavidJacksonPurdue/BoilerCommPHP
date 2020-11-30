<?php
require('dbCredentials.php');
function parseToXML($htmlStr)
{
    $xmlStr=str_replace('<','&lt;',$htmlStr);
    $xmlStr=str_replace('>','&gt;',$xmlStr);
    $xmlStr=str_replace('"','&quot;',$xmlStr);
    $xmlStr=str_replace("'",'&#39;',$xmlStr);
    $xmlStr=str_replace("&", '&amp;',$xmlStr);
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

$query = "SELECT f.*, t.topicName
FROM (topic_following f)
LEFT JOIN topic t on f.topicID = t.topicID
WHERE f.userID = '".$q."'";

$result = mysqli_query($connection, $query);

if (!$result) {
    echo "FAIL";
    die('Invalid query: ' . mysqli_error($connection));
}

header('Access-Control-Allow-Origin: *');
header("Content-type: text/xml");

// Start XML file, echo parent node
echo "<?xml version='1.0' ?>";
echo '<topic_following>';
$index=0;

while ($row = @mysqli_fetch_assoc($result)){
    // Add to XML document node
    echo '<topic ';
    echo 'topicID="' . $row['topicID'] . '" ';
    echo 'topicName="' . $row['topicName'] . '" ';
    echo '/>';
    $index = $index + 1;
}

// End XML file
echo '</topic_following>';
$connection->close();
