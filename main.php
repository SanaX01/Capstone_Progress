<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: welcome.php");
    exit;
}
 
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = $login_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT user_id, username, password FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($conn, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = $username;

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;                            
                            
                            // Redirect user to welcome page
                            header("location: welcome.php");
                        } else{
                            // Password is not valid, display a generic error message
                            $login_err = "Invalid username or password.";
                            
                        }
                    }
                } else{
                    // Username doesn't exist, display a generic error message
                    $login_err = "Invalid username or password.";
                    
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
            
            
            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($conn);
}
    
   $sql = "SELECT * FROM bookdeets";
   $result = mysqli_query($conn, $sql) or die("bad query: $sql");
?>
 
<!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8">
<title>main</title>
<meta name="viewport" content="width=device-width,initial-scale=1">

<link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css" />

<!-- font awesome cdn link  -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"  />
<link rel="stylesheet" href="css/mainStyle.css">

<head>

</head>
<body>

  <header class="header">

<div class="header-1">
  
  <div id="navbar" class="nav-wrapper">
    <!-- Navbar Logo -->
    
    <div class="logo">
      <a href="#home"></i> e-Libro<span>swap</span></a>
    </div>
    <!-- Navbar Links -->
    <ul id="menu">
      <li><a href="#home">Home</a></li><!--
   --><li><a href="#services">Services</a></li><!--
   --><li><a href="#about">About</a></li><!--
   --><li><a href="#contact">Contact</a></li>
    </ul>
  </div>
  <div class="menuIcon2">
    <span class="icon icon-bars"></span>
    <span class="icon icon-bars overlay"></span>
  </div>
  <div class="menuIcon">
      <div class="icons">
      <div id="login-btn" class="fas fa-user"></div>
          </div>
  </div>

</div>
<div class="overlay-menu">
  <ul id="menu">
      <li><a href="#home">Home</a></li>
      <li><a href="#services">Services</a></li>
      <li><a href="#about">About</a></li>
      <li><a href="#contact">Contact</a></li>
    </ul>
</div>
</div>
  </header>
  <!-- header section ends -->

<!-- bottom navbar  -->

<nav class="bottom-navbar">
  <a href="#home" class="fas fa-home"></a>
  <a href="#featured" class="fas fa-list"></a>
  <a href="#arrivals" class="fas fa-tags"></a>
  <a href="#reviews" class="fas fa-comments"></a>
  <a href="#blogs" class="fas fa-blog"></a>
</nav>

<!-- login form  -->

<div class="login-form-container">

  <div id="close-login-btn" class="fas fa-times"></div>

  <div class="wrapper">
        <h2>Login</h2>
        <p>Please fill in your credentials to login.</p>

        <?php 
        if(!empty($login_err)){
            echo '<div class="alert alert-danger" style="font-size: 20px;">' . $login_err . '</div>';
        }   
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="box <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="box <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Login">
            </div>
            <p>Don't have an account? <a href="register.php">Sign up now</a>.</p>
            
        </form>
    </div>

</div>

<!-- home section starts  -->

<section class="home" id="home">

  <div class="row">

      <div class="content">
          <h3>upto 75% off</h3>
          <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Magnam deserunt nostrum accusamus. Nam alias sit necessitatibus, aliquid ex minima at!</p>
          
      </div>

      <div class="swiper books-slider">
          <div class="swiper-wrapper">
              <?php if(mysqli_num_rows($result)> 0){
           while($rows = mysqli_fetch_array($result)){
               echo "<a class='swiper-slide' href='DisplayBooks.php?id={$rows['book_id']}'><br>\n";
               
               echo "<img src='Books/{$rows['bookimg_dir']}'>";
           }
       } else {
        echo "<h2> No data to display</h2>";
    }?>
              
          </div>
          
      </div>

  </div>

</section>

<!-- home section ense  -->

<!-- icons section starts  -->

<section class="icons-container">

  <div class="icons">
  <i class="fa-solid fa-truck"></i>

      <div class="content">
          <h3>free shipping</h3>
          <p>order over $100</p>
      </div>
  </div>

  <div class="icons">
      <i class="fas fa-lock"></i>
      <div class="content">
          <h3>secure payment</h3>
          <p>100 secure payment</p>
      </div>
  </div>

  <div class="icons">
      <i class="fas fa-redo-alt"></i>
      <div class="content">
          <h3>easy returns</h3>
          <p>10 days returns</p>
      </div>
  </div>

  <div class="icons">
      <i class="fas fa-headset"></i>
      <div class="content">
          <h3>24/7 support</h3>
          <p>call us anytime</p>
      </div>
  </div>

</section>

<!-- icons section ends -->

<!-- featured section starts  -->

<section class="featured" id="featured">

  <h1 class="heading"> <span>featured books</span> </h1>

  <div class="swiper featured-slider">

      <div class="swiper-wrapper">

          <div class="swiper-slide box">
              <div class="icons">
                  <a href="#" class="fas fa-search"></a>
                  <a href="#" class="fas fa-heart"></a>
                  <a href="#" class="fas fa-eye"></a>
              </div>
              <div class="image">
                  <img src="image/book-1.png" alt="">
              </div>
              <div class="content">
                  <h3>featured books</h3>
                  <div class="price">$15.99 <span>$20.99</span></div>
                  <a href="#" class="btn">add to cart</a>
              </div>
          </div>

          <div class="swiper-slide box">
              <div class="icons">
                  <a href="#" class="fas fa-search"></a>
                  <a href="#" class="fas fa-heart"></a>
                  <a href="#" class="fas fa-eye"></a>
              </div>
              <div class="image">
                  <img src="image/book-2.png" alt="">
              </div>
              <div class="content">
                  <h3>featured books</h3>
                  <div class="price">$15.99 <span>$20.99</span></div>
                  <a href="#" class="btn">add to cart</a>
              </div>
          </div>

          <div class="swiper-slide box">
              <div class="icons">
                  <a href="#" class="fas fa-search"></a>
                  <a href="#" class="fas fa-heart"></a>
                  <a href="#" class="fas fa-eye"></a>
              </div>
              <div class="image">
                  <img src="image/book-3.png" alt="">
              </div>
              <div class="content">
                  <h3>featured books</h3>
                  <div class="price">$15.99 <span>$20.99</span></div>
                  <a href="#" class="btn">add to cart</a>
              </div>
          </div>

          <div class="swiper-slide box">
              <div class="icons">
                  <a href="#" class="fas fa-search"></a>
                  <a href="#" class="fas fa-heart"></a>
                  <a href="#" class="fas fa-eye"></a>
              </div>
              <div class="image">
                  <img src="image/book-4.png" alt="">
              </div>
              <div class="content">
                  <h3>featured books</h3>
                  <div class="price">$15.99 <span>$20.99</span></div>
                  <a href="#" class="btn">add to cart</a>
              </div>
          </div>

          <div class="swiper-slide box">
              <div class="icons">
                  <a href="#" class="fas fa-search"></a>
                  <a href="#" class="fas fa-heart"></a>
                  <a href="#" class="fas fa-eye"></a>
              </div>
              <div class="image">
                  <img src="image/book-5.png" alt="">
              </div>
              <div class="content">
                  <h3>featured books</h3>
                  <div class="price">$15.99 <span>$20.99</span></div>
                  <a href="#" class="btn">add to cart</a>
              </div>
          </div>

          <div class="swiper-slide box">
              <div class="icons">
                  <a href="#" class="fas fa-search"></a>
                  <a href="#" class="fas fa-heart"></a>
                  <a href="#" class="fas fa-eye"></a>
              </div>
              <div class="image">
                  <img src="image/book-6.png" alt="">
              </div>
              <div class="content">
                  <h3>featured books</h3>
                  <div class="price">$15.99 <span>$20.99</span></div>
                  <a href="#" class="btn">add to cart</a>
              </div>
          </div>

          <div class="swiper-slide box">
              <div class="icons">
                  <a href="#" class="fas fa-search"></a>
                  <a href="#" class="fas fa-heart"></a>
                  <a href="#" class="fas fa-eye"></a>
              </div>
              <div class="image">
                  <img src="image/book-7.png" alt="">
              </div>
              <div class="content">
                  <h3>featured books</h3>
                  <div class="price">$15.99 <span>$20.99</span></div>
                  <a href="#" class="btn">add to cart</a>
              </div>
          </div>

          <div class="swiper-slide box">
              <div class="icons">
                  <a href="#" class="fas fa-search"></a>
                  <a href="#" class="fas fa-heart"></a>
                  <a href="#" class="fas fa-eye"></a>
              </div>
              <div class="image">
                  <img src="image/book-8.png" alt="">
              </div>
              <div class="content">
                  <h3>featured books</h3>
                  <div class="price">$15.99 <span>$20.99</span></div>
                  <a href="#" class="btn">add to cart</a>
              </div>
          </div>

          <div class="swiper-slide box">
              <div class="icons">
                  <a href="#" class="fas fa-search"></a>
                  <a href="#" class="fas fa-heart"></a>
                  <a href="#" class="fas fa-eye"></a>
              </div>
              <div class="image">
                  <img src="image/book-9.png" alt="">
              </div>
              <div class="content">
                  <h3>featured books</h3>
                  <div class="price">$15.99 <span>$20.99</span></div>
                  <a href="#" class="btn">add to cart</a>
              </div>
          </div>

          <div class="swiper-slide box">
              <div class="icons">
                  <a href="#" class="fas fa-search"></a>
                  <a href="#" class="fas fa-heart"></a>
                  <a href="#" class="fas fa-eye"></a>
              </div>
              <div class="image">
                  <img src="image/book-10.png" alt="">
              </div>
              <div class="content">
                  <h3>featured books</h3>
                  <div class="price">$15.99 <span>$20.99</span></div>
                  <a href="#" class="btn">add to cart</a>
              </div>
          </div>

      </div>

      <div class="swiper-button-next"></div>
      <div class="swiper-button-prev"></div>

  </div>

</section>

<!-- featured section ends -->

<!-- newsletter section starts -->

<section class="newsletter">

  <form action="">
      <h3>subscribe for latest updates</h3>
      <input type="email" name="" placeholder="enter your email" id="" class="box">
      <input type="submit" value="subscribe" class="btn">
  </form>

</section>

<!-- newsletter section ends -->

<!-- arrivals section starts  -->

<section class="arrivals" id="arrivals">

  <h1 class="heading"> <span>new arrivals</span> </h1>

  <div class="swiper arrivals-slider">

      <div class="swiper-wrapper">

          <a href="#" class="swiper-slide box">
              <div class="image">
                  <img src="image/book-1.png" alt="">
              </div>
              <div class="content">
                  <h3>new arrivals</h3>
                  <div class="price">$15.99 <span>$20.99</span></div>
                  <div class="stars">
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star-half-alt"></i>
                  </div>
              </div>
          </a>

          <a href="#" class="swiper-slide box">
              <div class="image">
                  <img src="image/book-2.png" alt="">
              </div>
              <div class="content">
                  <h3>new arrivals</h3>
                  <div class="price">$15.99 <span>$20.99</span></div>
                  <div class="stars">
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star-half-alt"></i>
                  </div>
              </div>
          </a>

          <a href="#" class="swiper-slide box">
              <div class="image">
                  <img src="image/book-3.png" alt="">
              </div>
              <div class="content">
                  <h3>new arrivals</h3>
                  <div class="price">$15.99 <span>$20.99</span></div>
                  <div class="stars">
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star-half-alt"></i>
                  </div>
              </div>
          </a>

          <a href="#" class="swiper-slide box">
              <div class="image">
                  <img src="image/book-4.png" alt="">
              </div>
              <div class="content">
                  <h3>new arrivals</h3>
                  <div class="price">$15.99 <span>$20.99</span></div>
                  <div class="stars">
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star-half-alt"></i>
                  </div>
              </div>
          </a>

          <a href="#" class="swiper-slide box">
              <div class="image">
                  <img src="image/book-5.png" alt="">
              </div>
              <div class="content">
                  <h3>new arrivals</h3>
                  <div class="price">$15.99 <span>$20.99</span></div>
                  <div class="stars">
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star-half-alt"></i>
                  </div>
              </div>
          </a>

      </div>

  </div>

  <div class="swiper arrivals-slider">

      <div class="swiper-wrapper">

          <a href="#" class="swiper-slide box">
              <div class="image">
                  <img src="image/book-6.png" alt="">
              </div>
              <div class="content">
                  <h3>new arrivals</h3>
                  <div class="price">$15.99 <span>$20.99</span></div>
                  <div class="stars">
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star-half-alt"></i>
                  </div>
              </div>
          </a>

          <a href="#" class="swiper-slide box">
              <div class="image">
                  <img src="image/book-7.png" alt="">
              </div>
              <div class="content">
                  <h3>new arrivals</h3>
                  <div class="price">$15.99 <span>$20.99</span></div>
                  <div class="stars">
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star-half-alt"></i>
                  </div>
              </div>
          </a>

          <a href="#" class="swiper-slide box">
              <div class="image">
                  <img src="image/book-8.png" alt="">
              </div>
              <div class="content">
                  <h3>new arrivals</h3>
                  <div class="price">$15.99 <span>$20.99</span></div>
                  <div class="stars">
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star-half-alt"></i>
                  </div>
              </div>
          </a>

          <a href="#" class="swiper-slide box">
              <div class="image">
                  <img src="image/book-9.png" alt="">
              </div>
              <div class="content">
                  <h3>new arrivals</h3>
                  <div class="price">$15.99 <span>$20.99</span></div>
                  <div class="stars">
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star-half-alt"></i>
                  </div>
              </div>
          </a>

          <a href="#" class="swiper-slide box">
              <div class="image">
                  <img src="image/book-10.png" alt="">
              </div>
              <div class="content">
                  <h3>new arrivals</h3>
                  <div class="price">$15.99 <span>$20.99</span></div>
                  <div class="stars">
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star-half-alt"></i>
                  </div>
              </div>
          </a>

      </div>

  </div>

</section>

<!-- arrivals section ends -->

<!-- deal section starts  -->

<section class="deal">

  <div class="content">
      <h3>deal of the day</h3>
      <h1>upto 50% off</h1>
      <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Unde perspiciatis in atque dolore tempora quaerat at fuga dolorum natus velit.</p>
      <a href="#" class="btn">shop now</a>
  </div>

  <div class="image">
      <img src="image/deal-img.jpg" alt="">
  </div>

</section>

<!-- deal section ends -->

<!-- reviews section starts  -->

<section class="reviews" id="reviews">

  <h1 class="heading"> <span>client's reviews</span> </h1>

  <div class="swiper reviews-slider">

      <div class="swiper-wrapper">

          <div class="swiper-slide box">
              <img src="image/pic-1.png" alt="">
              <h3>Itang</h3>
              <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Aspernatur nihil ipsa placeat. Aperiam at sint, eos ex similique facere hic.</p>
              <div class="stars">
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star-half-alt"></i>
              </div>
          </div>

          <div class="swiper-slide box">
              <img src="image/pic-2.png" alt="">
              <h3>joseph</h3>
              <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Aspernatur nihil ipsa placeat. Aperiam at sint, eos ex similique facere hic.</p>
              <div class="stars">
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star-half-alt"></i>
              </div>
          </div>

          <div class="swiper-slide box">
              <img src="image/pic-3.png" alt="">
              <h3>joshua</h3>
              <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Aspernatur nihil ipsa placeat. Aperiam at sint, eos ex similique facere hic.</p>
              <div class="stars">
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star-half-alt"></i>
              </div>
          </div>
          <div class="swiper-slide box">
              <img src="image/pic-4.png" alt="">
              <h3>chester</h3>
              <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Aspernatur nihil ipsa placeat. Aperiam at sint, eos ex similique facere hic.</p>
              <div class="stars">
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star-half-alt"></i>
              </div>
          </div>

          <div class="swiper-slide box">
              <img src="image/pic-5.png" alt="">
              <h3>jonas</h3>
              <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Aspernatur nihil ipsa placeat. Aperiam at sint, eos ex similique facere hic.</p>
              <div class="stars">
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star-half-alt"></i>
              </div>
          </div>

          <div class="swiper-slide box">
              <img src="image/pic-6.png" alt="">
              <h3>jep</h3>
              <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Aspernatur nihil ipsa placeat. Aperiam at sint, eos ex similique facere hic.</p>
              <div class="stars">
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star-half-alt"></i>
              </div>
          </div>

      </div>

  </div>
  
</section>

<!-- reviews section ends -->

<!-- blogs section starts  -->

<section class="blogs" id="blogs">

  <h1 class="heading"> <span>our blogs</span> </h1>

  <div class="swiper blogs-slider">

      <div class="swiper-wrapper">

          <div class="swiper-slide box">
              <div class="image">
                  <img src="image/blog-1.jpg" alt="">
              </div>
              <div class="content">
                  <h3>blog title goes here</h3>
                  <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Optio, odio.</p>
                  <a href="#" class="btn">read more</a>
              </div>
          </div>

          <div class="swiper-slide box">
              <div class="image">
                  <img src="image/blog-2.jpg" alt="">
              </div>
              <div class="content">
                  <h3>blog title goes here</h3>
                  <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Optio, odio.</p>
                  <a href="#" class="btn">read more</a>
              </div>
          </div>

          <div class="swiper-slide box">
              <div class="image">
                  <img src="image/blog-3.jpg" alt="">
              </div>
              <div class="content">
                  <h3>blog title goes here</h3>
                  <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Optio, odio.</p>
                  <a href="#" class="btn">read more</a>
              </div>
          </div>

          <div class="swiper-slide box">
              <div class="image">
                  <img src="image/blog-4.jpg" alt="">
              </div>
              <div class="content">
                  <h3>blog title goes here</h3>
                  <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Optio, odio.</p>
                  <a href="#" class="btn">read more</a>
              </div>
          </div>

          <div class="swiper-slide box">
              <div class="image">
                  <img src="image/blog-5.jpg" alt="">
              </div>
              <div class="content">
                  <h3>blog title goes here</h3>
                  <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Optio, odio.</p>
                  <a href="#" class="btn">read more</a>
              </div>
          </div>

      </div>

  </div>

</section>

<!-- blogs section ends -->

<!-- footer section starts  -->

<section class="footer">

  <div class="box-container">

      <div class="box">
          <h3>our locations</h3>
          <a href="#"> <i class="fas fa-map-marker-alt"></i> india </a>
          <a href="#"> <i class="fas fa-map-marker-alt"></i> USA </a>
          <a href="#"> <i class="fas fa-map-marker-alt"></i> russia </a>
          <a href="#"> <i class="fas fa-map-marker-alt"></i> france </a>
          <a href="#"> <i class="fas fa-map-marker-alt"></i> japan </a>
          <a href="#"> <i class="fas fa-map-marker-alt"></i> africa </a>
      </div>

      <div class="box">
          <h3>quick links</h3>
          <a href="#"> <i class="fas fa-arrow-right"></i> home </a>
          <a href="#"> <i class="fas fa-arrow-right"></i> featured </a>
          <a href="#"> <i class="fas fa-arrow-right"></i> arrivals </a>
          <a href="#"> <i class="fas fa-arrow-right"></i> reviews </a>
          <a href="#"> <i class="fas fa-arrow-right"></i> blogs </a>
      </div>

      <div class="box">
          <h3>extra links</h3>
          <a href="#"> <i class="fas fa-arrow-right"></i> account info </a>
          <a href="#"> <i class="fas fa-arrow-right"></i> ordered items </a>
          <a href="#"> <i class="fas fa-arrow-right"></i> privacy policy </a>
          <a href="#"> <i class="fas fa-arrow-right"></i> payment method </a>
          <a href="#"> <i class="fas fa-arrow-right"></i> our serivces </a>
      </div>

      <div class="box">
          <h3>contact info</h3>
          <a href="#"> <i class="fas fa-phone"></i> +63912345678 </a>
          <a href="#"> <i class="fas fa-phone"></i> +63912345678 </a>
          <a href="#"> <i class="fas fa-envelope"></i> christianjade.cjt@gmail.com </a>
          <img src="image/worldmap.png" class="map" alt="">
      </div>
      
  </div>

  <div class="share">
      <a href="#" class="fab fa-facebook-f"></a>
      <a href="#" class="fab fa-twitter"></a>
      <a href="#" class="fab fa-instagram"></a>
      <a href="#" class="fab fa-linkedin"></a>
      <a href="#" class="fab fa-pinterest"></a>
  </div>

  <div class="credit"> created by <span>e-Libro Group</span> </div>

</section>

<!-- footer section ends -->

<!-- loader  -->

<script src="https://unpkg.com/swiper@7/swiper-bundle.min.js"></script>


      <script type = "text/javascript" src="mainAnimation.js"></script>  
</body>

</html>
