<?php
require('dbCredentials.php');
$q = $_REQUEST["q"];
$inputArray = explode("_", $q);
$email = $inputArray[0];
$password = $inputArray[1];


global $hst;
global $usr;
global $pswrd;
global $db;

// Opens a connection to a MySQL server
$connection=mysqli_connect ($hst, $usr, $pswrd, $db);
if (!$connection) {
    die('Not connected : ' . mysqli_connect_error());
}

$query = "SELECT userID, userName, PASSWORD FROM user
    WHERE
        email = '".$email."'";

$result = mysqli_query($connection, $query);
if ($connection->query($query) === TRUE) {
    echo "Login Failed, Connection Failed";
    die('Invalid query: ' . mysqli_error($connection));
}
else {
    while($row = $result->fetch_array()) {
        echo $row['userID'] . " " . $row['userName'] . " " . $row['PASSWORD'];
    }
}
?>