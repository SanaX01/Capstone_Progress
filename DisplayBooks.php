<?php
        
require_once('configbooks.php');
session_start();
//$bookid = '';

if(isset($_GET['id'])){
    $ID = mysqli_real_escape_string($conn, $_GET['id']);
    $sql = "SELECT * FROM bookdeets WHERE book_id=$ID";
    $result = mysqli_query($conn, $sql) or die('Bad query: $sql');
    $row = mysqli_fetch_array($result);
}

?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="style1.css" >
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
</head>
<body>
   
   
   <h2></h2>

   <main>
    <div class="card">
      <div class="card__title">
        <div class="icon">
          <a href="main.php"><i class="fa fa-arrow-left"></i></a>
        </div>
        <h3><?php echo $row['genre'] ?></h3>
      </div>
      <div class="card__body">
        <div class="half">
          <div class="featured_text">
          <h1><?php echo $row['title'] ?></h1>
            <p class="sub"> </p>
            <p class="price">₱210.00</p>
          </div>
          <div class="image">
          <img src='Books/<?php echo $row['bookimg_dir'] ?>'>
          </div>
        </div>
        <div class="half">
          <div class="description">
            <p><?php echo $row['description'] ?></p>
          </div>
          <span class="stock"><i class="fa fa-pen"></i> In stock</span>
          <div class="reviews">
            <ul class="stars">
              <li><i class="fa fa-star"></i></li>
              <li><i class="fa fa-star"></i></li>
              <li><i class="fa fa-star"></i></li>
              <li><i class="fa fa-star"></i></li>
              <li><i class="fa fa-star-o"></i></li>
            </ul>
            <span>(64 reviews)</span>
          </div>
        </div>
      </div>
      <div class="card__footer">
        <div class="recommend">
          <p>Author</p>
          <h3><?php echo $row['author'] ?></h3>
        </div>
        <div class="action">
          <button type="button">Add to cart</button>
        </div>
      </div>
    </div>
  </main>
</body>
</html>
