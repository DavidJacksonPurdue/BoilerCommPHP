<?php
//these are the server details
//the username is root by default in case of xampp
//password is nothing by default
//and lastly we have the database named android. if your database name is different you have to change it
require('dbCredentials.php');
$dm_id_fk = $_REQUEST["q"];

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
$query = "select d.user_id, u.username, d.body, d.time from dm_messages d join user u on d.user_id = u.userID where dm_id_fk = '".$dm_id_fk."' order by time asc";

//this is our sql query


//creating an statement with the query
$result = mysqli_query($connection, $query);

if (!$result) {
    die('Invalid query: ' . mysqli_error($connection));
}


header('Access-Control-Allow-Origin: *');
header("Content-type: text/xml");

// Start XML file, echo parent node
echo "<?xml version='1.0' ?>";
echo '<dms>';
$ind=0;
// Iterate through the rows, printing XML nodes for each
while ($row = @mysqli_fetch_assoc($result)){
    // Add to XML document node
    echo '<dm_message ';
    echo 'userID="' . $row['user_id'] . '" ';
    echo 'username="' . $row['username'] . '" ';
    echo 'body="' . $row['body'] . '" ';
    echo 'time="' . $row['time'] . '" ';
    echo '/>';
    $ind = $ind + 1;
}

// End XML file
echo '</dms>';
$connection->close();
