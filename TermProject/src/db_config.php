<?php


$servername = "sysmysql8.auburn.edu";  /*(This is the server-name from the top of this instructions page.)*/
$username = "xxxxxx";
$password = "xxxxxxx";
$db = "xxxxxx";
 
// Create connection
$conn = new mysqli($servername, $username, $password, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
 
?>
