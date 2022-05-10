<?php
$servername = "localhost";
$user = "root";
$password = "";
$db = "books";

// Create connection

$conn = mysqli_connect($servername, $user, $password, $db);


// Check connection

if (mysqli_connect_errno()) {
   die("Connect failed: %s\n" + mysqli_connect_error());
   exit();
}