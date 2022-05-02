<?php
$servername = "localhost";
$username = "root";
$password = "";
$db = "users";

// Create connection

$conn = mysqli_connect($servername, $username, $password, $db);


// Check connection

if (mysqli_connect_errno()) {
   die("Connect failed: %s\n" + mysqli_connect_error());
   exit();
}