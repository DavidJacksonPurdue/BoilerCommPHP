<?php
require('dbCredentials.php');
$q = $_REQUEST["q"];
$inputArray = explode("_", $q);
$followingCase = $inputArray[0];
$uid = $inputArray[1];
$otherUID = $inputArray[2];
global $hst;
global $usr;
global $pswrd;
global $db;

//creating a new connection object using mysqli
$connection=mysqli_connect ($hst, $usr, $pswrd, $db);
if (!$connection) {
    die('Not connected : ' . mysqli_connect_error());
}
if($followingCase == "0") {
    $query = "SELECT blockedID FROM blocking WHERE userID = '" . $uid . "'";
    $result = mysqli_query($connection, $query);
    if (!$result) {
        die('Invalid query: ' . mysqli_error($connection));
    }
    header('Access-Control-Allow-Origin: *');
    header("Content-type: text/xml");
    echo "<?xml version='1.0' ?>";
    echo '<blocked>';
    echo '<block ';
    $ran = 0;
    while ($row = @mysqli_fetch_assoc($result)) {
        $curBlockedID = $row['blockedID'];
        if ($curBlockedID == $otherUID) {
            echo 'is_blocked="' . "true" . '" ';
            echo '/>';
            echo '</blocked>';
            $ran = 1;
            break;
        }
    }
    if ($ran == 0) {
        echo 'is_blocked="' . "false" . '" ';
        echo '/>';
        echo '</blocked>';
    }
}else{
    $query = "SELECT followerID FROM following WHERE userID = '" . $uid . "'";
    $result = mysqli_query($connection, $query);
    if (!$result) {
        die('Invalid query: ' . mysqli_error($connection));
    }
    header('Access-Control-Allow-Origin: *');
    header("Content-type: text/xml");
    echo "<?xml version='1.0' ?>";
    echo '<blocked>';
    echo '<block ';
    $ran = 0;
    while ($row = @mysqli_fetch_assoc($result)) {
        $curFollowerID = $row['followerID'];
        if ($curFollowerID == $otherUID) {
            echo 'is_blocked="' . "false" . '" ';
            echo '/>';
            echo '</blocked>';
            $ran = 1;
            break;
        }
    }
    if ($ran == 0) {
        echo 'is_blocked="' . "true" . '" ';
        echo '/>';
        echo '</blocked>';
    }
}
$connection->close();