<?php
$q = $_REQUEST["q"];
$inputArray = explode("_", $q);
$user_id = $inputArray[0];
// File written by Nick Rosato
// CS 307: Delete a user from a mySQL table
// ID will need to be inputted to this script
$servername = "127.0.0.1"; // don't use localhost, will generate an error
$username = "root"; // fill in your database here
$password = "Alivanzavashin1"; // fill in your password here
$dbname = "cs307_testdb_schema"; // fill in database name here
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
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