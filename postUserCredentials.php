<?php
require('dbCredentials.php');

global $hst;
global $usr;
global $pswrd;
global $db;

if($_SERVER['REQUEST_METHOD'] =='POST'){
    $image = $_POST['image'];
    $con=mysqli_connect ($hst, $usr, $pswrd, $db);
    if (!$con) {
        die('Not connected : ' . mysqli_connect_error());
    }

    $sql = "UPDATE user 
SET
    firstName = '".$firstName."',
    lastName = '".$lastName."',
    email = '".$email."',
    PASSWORD = '".$password."',
    profilePic = '".$profilePic."'
WHERE
    userID =".$userId;


    $stmt = mysqli_prepare($con,$sql);

    mysqli_stmt_bind_param($stmt,"s",$image);
    mysqli_stmt_execute($stmt);

    $check = mysqli_stmt_affected_rows($stmt);

    if($check == 1){
        echo "Image Uploaded Successfully";
    }else{
        echo "Error Uploading Image";
    }
    mysqli_close($con);
} else {
    echo "Error";
}
?>