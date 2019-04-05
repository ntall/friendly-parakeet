<?php
session_start();
// Check if the user is already logged in, if yes then redirect him to home page
if(isset($_SESSION["user_id"]) && $_SESSION["user_id"] === true){
    header("location: index.php");
    exit;
} 
require 'services/connect.php';
require 'header.php';

$username = $passwordAttempt = "";
$username_err = $password_err = "";
 

if(isset($_POST['login'])){
    
    //Retrieve the field values from login form.
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $passwordAttempt = trim($_POST["password"]);
    }
    
    //Retrieve the user account information for the given username.
    $sql = "SELECT * FROM users WHERE email = :username";
    $stmt = $pdo->prepare($sql);
    
    //Bind value.
    $stmt->bindValue(':username', $username);
    
    //Execute.
    $stmt->execute();
    
    //Fetch row.
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if(empty($username_err) && empty($password_err)){
    //If $row is FALSE.
    if($user === false){
        //Could not find a user with that username!
        $username_err = "No account found with that username.";
    } else{
        //User account found. Check to see if the given password matches the
        //password hash that we stored in our users table.
        
        //Compare the passwords.

        $validPassword = password_verify($passwordAttempt, $user['password']);

        //If $validPassword is TRUE, the login has been successful.
        if($validPassword == true){
            
            //Provide the user with a login session.
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['logged_in'] = time();
            $_SESSION['expire'] = $_SESSION['logged_in'] + (1 * 60);
            
            //Redirect to our protected page, which we called home.php
            header('Location: index.php');
            exit;
            
        } else{
            //$validPassword was FALSE. Passwords do not match.
            $password_err = "The password you entered was not valid.";
        }
    }
    
}
}//Made use a small chunk of code from https://www.tutorialrepublic.com/php-tutorial/php-mysql-login-system.php
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="asg2.css">
</head>
<body>
    <div class="container">
       
        <!-- 
            create login form
          -->
        <h1 id='title'>Log in</h1>
        <p>Please fill in your credentials to login.</p>
        <form action="login.php" method="post" class="col-12 col-s-12">
            <div class="form-group">
                <label>Username</label>
                <input type="text" id="username" name="username" class="form-control" value="<?php echo isset($_POST['username']) ? $_POST['username'] : '' ?>" />
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>
            <div class="form-group">    
                <label>Password</label>
                <input type="password" id="password" name="password" class="form-control">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" name="login" value="Login" class="btn btn-primary">
            </div>
            <p>Don't have an account? <a href="register.php">Sign up now</a>.</p>
        </form>
    </div>   
<script>
        /*script for form input */
        function setBackground(e) {
         if (e.type == "focus") {
         e.target.style.backgroundColor = "#F0E393";
         }
         else if (e.type == "blur") {
         e.target.style.backgroundColor = "white";
         }
        }
        
         const cssSelector = "input[type=text],input[type=password]";
         const fields = document.querySelectorAll(cssSelector);
        
         for (let field of fields) {
         field.addEventListener("focus", setBackground);
         field.addEventListener("blur", setBackground);
         }
</script>
</body>

</html>
