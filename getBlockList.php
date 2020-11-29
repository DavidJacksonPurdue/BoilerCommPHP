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

$query = "SELECT b.*, u.userName
FROM (blocking b)
LEFT JOIN user u on b.blockedID = u.userID
WHERE b.userID = '".$q."'";

$result = mysqli_query($connection, $query);

if (!$result) {
    echo "FAIL";
    die('Invalid query: ' . mysqli_error($connection));
}

header('Access-Control-Allow-Origin: *');
header("Content-type: text/xml");

// Start XML file, echo parent node
echo "<?xml version='1.0' ?>";
echo '<blocking>';
$index=0;

while ($row = @mysqli_fetch_assoc($result)){
    // Add to XML document node
    echo '<blocked ';
    echo 'userID="' . $row['blockedID'] . '" ';
    echo 'userName="' . $row['userName'] . '" ';
    echo '/>';
    $index = $index + 1;
}

// End XML file
echo '</blocking>';
$connection->close();
