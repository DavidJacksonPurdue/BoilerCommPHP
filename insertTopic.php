<?php
// Get the q parameter from URL
$q = $_REQUEST["q"];
$inputArray = explode("_", $q);
$topicID = $inputArray[0];
$topicName = $inputArray[1];

// Connect to the database
$connection = mysqli_connect('127.0.0.1', "root", 'Alivanzavashin1', 'cs307_testdb_schema');
if (!$connection) {
    die('Not connected: ' . mysql_connect_error());
}

// Query to see if the name exists in the database
$query = "SELECT topicID, topicName FROM topic WHERE topicName LIKE '{$topicName}'";
$result = mysqli_query($connection, $query);
if (!$result) {
    echo "Error creating topic: " . $connection;
}
$row = $result->fetch_array();
if (!$row) {
    //  If the name does not already exist add it to the database
    $query = "SELECT MAX(topicID) FROM topic";
    $result = mysqli_query($connection, $query);
    if (!$result) {
        return "could not get maxID";
    }
    $row = @mysqli_fetch_assoc($result);
    $topicID = $row['MAX(topicID)'] + 1;

    $query = "INSERT INTO topic (topicID, topicName)
          VALUES
          ('{$topicID}',
           '{$topicName}')";

    if ($connection->query($query) === TRUE) {
        // Return the topic ID of the newly created topic
        echo $topicID;
    } else {
        echo "Error creating topic: " . $connection;
    }
} else {
    // Return the topic ID of the prexisting topic
    echo $row[0];
}

$connection->close();
?>