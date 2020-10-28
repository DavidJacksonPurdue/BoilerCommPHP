<?php
require('dbCredentials.php');
global $hst;
global $usr;
global $pswrd;
global $db;
$q = $_REQUEST["q"];
$inputArray = explode("_", $q);
$user_id = $inputArray[0];
// File written by Nick Rosato
// CS 307: Delete a user from a mySQL table
// ID will need to be inputted to this script
$conn=mysqli_connect ($hst, $usr, $pswrd, $db);;
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// sql to delete a record
$sql = "DELETE FROM user WHERE userID=$user_id";
// check if deletion worked
if ($conn->query($sql) === TRUE) {
    echo "Record deleted successfully";
} else {
    echo "Error deleting record: " . $conn->error;
}
mysqli_select_db($conn, "cs307_testdb_schema");
$query ="SET SQL_SAFE_UPDATES = 0;
UPDATE post 
SET
    userID = -1
WHERE
    userID = '".$user_id."';";
$conn ->multi_query($query);
printf("Error message: %s\n", $conn->error);
// close connection
$conn->close();
?>