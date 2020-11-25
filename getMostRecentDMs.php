<?php
$userID = 1;
$connection=mysqli_connect ('127.0.0.1', "newuser", '', 'cs307');
if (!$connection) {
    die('Not connected : ' . mysqli_connect_error());
}
$query= "SELECT u.userID,d.dm_id,u.userName
 FROM dm d, user u
 WHERE CASE 
 WHEN d.user_id_one = '".$userID."'
 THEN d.user_id_two = u.userID
 WHEN d.user_id_two = '".$userID."'
 THEN d.user_id_one= u.userID
 END 
 AND (
 d.user_id_one = '".$userID."'
 OR d.user_id_two = '".$userID."'
 )
 Order by d.dm_id DESC Limit 20";


$result = mysqli_query($connection, $query);
if (!$result) {
    die('Invalid query: ' . mysqli_error($connection));
}
header('Access-Control-Allow-Origin: *');
header("Content-type: text/xml");
echo "<?xml version='1.0' ?>";
echo '<dms>';
while($row = @mysqli_fetch_assoc($result))
{
    $dm_id=$row['dm_id'];
    $user_id=$row['userID'];
    $username=$row['userName'];
    $cquery= "SELECT dm_message_id,time,body
FROM dm_messages
WHERE dm_id_fk='".$dm_id."'
ORDER BY dm_message_id DESC LIMIT 1";

    $cresult = mysqli_query($connection, $cquery);
    if (!$cresult) {
        die('Invalid query: ' . mysqli_error($connection));
    }
    $crow=@mysqli_fetch_assoc($cresult);
    $dm_message_id=$crow['$dm_message_id'];
    $body=$crow['body'];
    $time=$crow['time'];
//HTML Output.
    echo '<dmz ';
    echo 'user_id="' .$user_id. '" ';
    echo 'username="' .$username. '" ';
    echo 'body="' .$body. '" ';
    echo 'time="' .$time. '" ';
    echo '/>';
}
echo '</dms>';
$connection->close();