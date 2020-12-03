<?php
// Get the q parameter from URL
require('dbCredentials.php');
$q = $_REQUEST["q"];



global $hst;
global $usr;
global $pswrd;
global $db;

// Opens a connection to a MySQL server
$connection=mysqli_connect ($hst, $usr, $pswrd, $db);
if (!$connection) {
    die('Not connected : ' . mysqli_connect_error());
}
$query1 = "Select * from limitdmtofollowing where userID = '".$q."'";

$result1 = mysqli_query($connection, $query1);

if (!$result1) {
    echo "FAIL";
    die('Invalid query: ' . mysqli_error($connection));
}

$exists = mysqli_num_rows($result1);

if ($exists >= 1) {
    $query2 = "SET SQL_SAFE_UPDATES = 0;
    delete from limitdmtofollowing where userID = '".$q."';";
    $connection ->multi_query($query2);
    echo "TRUE";
}
else {
    $query2 = "insert into limitdmtofollowing (userID) VALUES 
    ('".$q."')";
    $result2 = mysqli_query($connection, $query2);
    if (!$result2) {
        echo "FAIL";
        die('Invalid query: ' . mysqli_error($connection));
    }
    echo "FALSE";
}
$connection->close();
