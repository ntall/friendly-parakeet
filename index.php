<?php
session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
        <link rel="stylesheet" type="text/css" href="asg2.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>
    <body>
<?php
require 'services/connect.php';
?>
<main class="container">
  <!-- 
    set up unique header for home page(without 'home')
  -->

  <div class='logo'>
      <h1><img src='logo.png'></img>Stock Cooker</h1>
            <div class="dropdown">
                <button class="dropbtn">More 
                    <i class="fa fa-caret-down"></i>
                </button>
                <div class="dropdown-content">
                    <a href="about.php">About</a>
                    <a href="list.php">Companies</a>
                    <?php if(isset($_SESSION['user_id'])){ ?>
                    <a href="portfolio.php">Portfolio</a>
                    <a href="profile.php">Profile</a>
                    <a href="favorites.php">My Favorites</a>
                    <a href="logout.php">Logout</a>
                    <?php }else{ ?>
                    <a href="login.php">login</a>
                    <a href="register.php">Signup</a>
                    <?php } ?>
                </div>
            </div>
            <p><?php $d = date("l, F dS, Y");echo "Today is: $d" ?></p>
        </div>
<div id='head'>
    
        <?php 
        if(isset($_SESSION['user_id'])){
          echo "<h3> Welcome, ";
          $userid=$_SESSION['user_id'];
          $sql = "SELECT email FROM users WHERE id = :id";
          $stmt = $pdo->prepare($sql);
          $stmt->bindValue(':id', $userid);
          $stmt->execute();
          $user = $stmt->fetch(PDO::FETCH_ASSOC);
          echo "<em>";
          echo $user['email'];
          echo "</em>";
          echo "</h3>";
        }//show wecome message for each user
      ?>
     

</div>


<!-- 
    set up links for both logged in and not logged in user
  -->
    <h1 id='title'><em>Stock Cooker</em></h1>
    <div class='row'>
    <div class='col-5 col-s-11 home'><a href="about.php">About</div>
    <div class='col-5 col-s-11 home' id='comp'> <a href="list.php">Companies</a></div>
    <div <?php if(isset($_SESSION['user_id'])){ ?>
      class='col-5 col-s-11 home'><a href="portfolio.php">Portfolio</a>
    <?php }else{ ?>
      class='hidden'>
    <?php } ?></div>
    <div <?php if(isset($_SESSION['user_id'])){ ?>
      class='col-5 col-s-11 home'><a href="favorites.php">Favorites</a>
    <?php }else{ ?>
      class='hidden'>
    <?php } ?></div>
    <div <?php if(isset($_SESSION['user_id'])){ ?>
      class='col-5 col-s-11 home'><a href="profile.php">Profile</a>
    <?php }else{ ?>
      class='hidden'>
    <?php } ?></div>
    <div class='col-5 col-s-11 home' id='log'> 
    <?php if(isset($_SESSION['user_id'])){ ?>
      <a href="logout.php">Logout</a>
    <?php }else{ ?>
      <a href="login.php">login</a>
    <?php } ?></div>
    <div <?php if(isset($_SESSION['user_id'])){ ?>
      class='hidden'>
    <?php }else{ ?>
      class='col-5 col-s-11 home'><a href="register.php">Sign up</a>
    <?php } ?></div>

    </div>
</div>

</main>

</body>
</html>