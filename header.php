<html>
    <!-- 
    Create header for other pages
  -->
    <head>
        <meta charset="utf-8"/>
        <link rel="stylesheet" type="text/css" href="asg2.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>
    <body>
        <div class='logo'>
      <h1><img src='logo.png'></img>Stock Cooker</h1>
            <div class="dropdown">
                <button class="dropbtn">More 
                    <i class="fa fa-caret-down"></i>
                </button>
                <div class="dropdown-content">
                    <a href="index.php">Home</a>
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
            
    </body>
</html>