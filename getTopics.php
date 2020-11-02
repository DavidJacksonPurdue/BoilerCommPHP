<?php
require ('dbCredentials.php');
require('dbCredentials.php');
global $hst;
global $usr;
global $pswrd;
global $db;
// File written by Elijah Heminger
// CS 307: Will retrive all topics from a mySQL table
// No parameters will be needed from this script
$conn=mysqli_connect ($hst, $usr, $pswrd, $db);
// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}

// sql to request all topic names & id's
$query = "SELECT * FROM TOPIC";

$result = mysqli_query($conn, $query);
if (!$result) {
    die('Invalid query: ' . mysqli_error($connection));
}
header('Access-Control-Allow-Origin: *');
header("Content-type: text/xml");

// Start XML file, echo parent node
echo "<?xml version='1.0' ?>";
echo '<topics>';
$ind=0;
// Iterate through the rows, printing XML nodes for each
while ($row = @mysqli_fetch_assoc($result)){
    // Add to XML document node
    echo '<topic ';
    echo 'topicID="' . $row['topicID'] . '" ';
    echo 'topicName="' . $row['topicName'] . '" ';
    echo '/>';
    $ind = $ind + 1;
}

// End XML file
echo '</topics>';
$conn->close();


?>