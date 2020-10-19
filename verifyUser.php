<?php
// Get the q parameter from URL
$q = $_REQUEST["q"];
$inputArray = explode("_", $q);
$username = $inputArray[0];
$email = $inputArray[1];

// Opens a connection to a MySQL server
$connection=mysqli_connect ('127.0.0.1', "newuser", '', 'cs307');
if (!$connection) {
    die('Not connected : ' . mysqli_connect_error());
}

$query = "SELECT username FROM user WHERE username LIKE '{$username}'";
$result = mysqli_query($connection, $query);
if (!$result) {
    echo "could not get username:" . $connection->error;
}

// If user is in database, print a U
$row = @mysqli_fetch_assoc($result);
if ($row) {
    echo "U";
}

$query = "SELECT email FROM user WHERE email LIKE '{$email}'";
$result = mysqli_query($connection, $query);
if (!$result) {
    echo "could not get email";
}

// If email is in the database, print an E
$row = @mysqli_fetch_assoc($result);
if ($row) {
    echo "E";
}

echo "F";
$connection->close();

?>