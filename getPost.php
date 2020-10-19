<?php
//these are the server details
//the username is root by default in case of xampp
//password is nothing by default
//and lastly we have the database named android. if your database name is different you have to change it
$q = $_REQUEST["q"];
$servername = "127.0.0.1";
$username = "root";
$password = "Alivanzavashin1";
$database = "cs307_testdb_schema";


//creating a new connection object using mysqli
$conn = new mysqli($servername, $username, $password, $database);

//if there is some error connecting to the database
//with die we will stop the further execution by displaying a message causing the error
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//if everything is fine

//creating an array for storing the data
$posts = array();

//this is our sql query
$sql = "select p.postID, p.userID, p.topicID, t.topicName, p.postName, p.postText, p.postImage, p.postDate from post p join topic t on p.topicID = t.topicID where userID=".$q;


//creating an statement with the query
$stmt = $conn->prepare($sql);

//executing that statment
$stmt->execute();

//binding results for that statment
$stmt->bind_result($userID, $postID, $topicID, $topicName, $postName, $postText, $postImage, $postDate);

//looping through all the records
while($stmt->fetch()){

    //pushing fetched data in an array
    $temp = [
        'userID'=>$userID,
        'postID'=>$postID,
        'topicID'=>$topicID,
        'topicName'=>$topicName,
        'postName'=>$postName,
        'postText'=>$postText,
        'postImage'=>$postImage,
        'postDate'=>$postDate
    ];

    //pushing the array inside the hero array
    array_push($posts, $temp);
}

//displaying the data in json format
$array_final = json_encode($posts, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

echo $array_final;
