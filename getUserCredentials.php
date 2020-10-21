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






$query = "select * from user where userID=".$q;

$result = mysqli_query($connection, $query);
if (!$result) {
    die('Invalid query: ' . mysqli_error($connection));
}


header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

// Start XML file, echo parent node
$row = @mysqli_fetch_assoc($result);

echo json_encode($row);
$connection->close();
?>




