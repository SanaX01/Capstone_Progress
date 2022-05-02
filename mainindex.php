<?php
require_once('configbooks.php');
    session_start();

   $sql = "SELECT * FROM bookdeets";
   $result = mysqli_query($conn, $sql) or die("bad query: $sql");
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
   <div id="container">
       <?php 
       if(mysqli_num_rows($result)> 0){
           while($rows = mysqli_fetch_array($result)){
               echo "<a href='DisplayBooks.php?id={$rows['book_id']}'>{$rows['title']}<br>\n";
           }
       } else {
        echo "<h2> No data to display</h2>";
    }
       ?>
   </div>
</body>
</html>