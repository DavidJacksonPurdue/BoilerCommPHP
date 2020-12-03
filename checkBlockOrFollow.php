<?php
require('dbCredentials.php');
$q = $_REQUEST["q"];


global $hst;
global $usr;
global $pswrd;
global $db;

//creating a new connection object using mysqli
$connection=mysqli_connect ($hst, $usr, $pswrd, $db);
if (!$connection) {
    die('Not connected : ' . mysqli_connect_error());
}
$query = "SELECT * FROM limitdmtofollowing WHERE userID = '" . $q . "'";
$result = mysqli_query($connection, $query);
if (!$result) {
    die('Invalid query: ' . mysqli_error($connection));
}

header('Access-Control-Allow-Origin: *');
header("Content-type: text/xml");
echo "<?xml version='1.0' ?>";
echo '<blocked>';
echo '<block ';
if($row = @mysqli_fetch_assoc($result)){
    echo 'is_blocked="' . "true" . '" ';
    echo '/>';
}else{
    echo 'is_blocked="' . "false" . '" ';
    echo '/>';
}
echo '</blocked>';


$connection->close();