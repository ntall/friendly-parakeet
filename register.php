<?php
   session_start();
   require 'header.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Register</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
         <link rel="stylesheet" type="text/css" href="asg2.css">
    </head>
    <body>
        <div class="container">
            <h1>Register</h1>
            <!-- 
                Create registration form.
              -->
            <form action="register.php" method="post">
                <div class="form-group">
                <label for="fname">First Name</label>
                <input type="text" id="fname" name="fname" class="form-control" value="<?php echo isset($_POST['fname']) ? $_POST['fname'] : '' ?>" />
                </div>
                <div class="form-group">
                <label for="username">Last Name</label>
                <input type="text" id="lname" name="lname" class="form-control" value="<?php echo isset($_POST['lname']) ? $_POST['lname'] : '' ?>" />
                </div>
                <div class="form-group">
                <label for="username">City</label>
                <input type="text" id="city" name="city" class="form-control" value="<?php echo isset($_POST['city']) ? $_POST['city'] : '' ?>" />
                </div>
                <div class="form-group">
                <label for="username">Country</label>
                <input type="text" id="country" name="country" class="form-control" value="<?php echo isset($_POST['country']) ? $_POST['country'] : '' ?>" />
                </div>
                <div class="form-group">
                <label for="username">Username(Must be your Email)</label>
                <input type="text" id="username" name="username" class="form-control" value="<?php echo isset($_POST['username']) ? $_POST['username'] : '' ?>" />
                </div>
                <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" class="form-control" value="<?php echo isset($_POST['password']) ? $_POST['password'] : '' ?>" />
                </div>
                <div class="form-group">
                <label for="confirmPassword">Confirm Password</label>
                <input type="password" id="confirmPassword" name="confirmPassword" class="form-control" value="<?php echo isset($_POST['confirmPassword']) ? $_POST['confirmPassword'] : '' ?>" />
                </div>
                <div class="form-group">
                <input type="submit" id="submitted" name="register" value="Register" class="btn btn-primary">
                <span id="login" class="btn btn-primary"><a href="login.php">Log in</a></span>
                </div>

            </form>
            <div id="errors" class="hidden"></div>
            <div id="emailErrors" class="hidden"></div>
            <div id="passwordErrors" class="hidden"></div>
            <div id="existErrors" class="hidden"></div>
            
        </div>
    <script>
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
            // script for validate all user input
            document.querySelector('#submitted').addEventListener('click', checkForEmptyFields);
            function checkForEmptyFields(e) {
                const errorArea = document.querySelector('#errors');
                console.log("asdasd");
             // loop thru the input elements looking for empty values
             const errorList = [];
             for (let field of fields) {
                if (field.value == null || field.value == "") {
                // since a field is empty prevent the form submission
                e.preventDefault();
                errorList.push(field);
                }
              }
             var msg = "The following fields can't be empty: ";
             if (errorList.length > 0) {
                for (let errorField of errorList) {
                 msg += errorField.id + ", ";
                }
                errorArea.innerHTML = "<p>" + msg + "</p>";
                errorArea.className = "visible";
              }
             }
             document.querySelector('#submitted').addEventListener('click', validatePassword);
             var password = document.getElementById("password")
              , confirm_password = document.getElementById("confirmPassword");
            
            function validatePassword(e){
                const errorArea = document.querySelector('#passwordErrors');
              if(password.value != confirm_password.value) {
                //confirm_password.setCustomValidity("Passwords Don't Match");
                e.preventDefault();
                errorArea.innerHTML = "<p>" + "Passwords Don't Match" + "</p>";
                errorArea.className = "visible";
                
              }else if(password.value.length < 8){
                  //confirm_password.setCustomValidity("Passwords Must At Least 8 Character Long");
                e.preventDefault();
                errorArea.innerHTML = "<p>" + "Passwords Must At Least 8 Character Long" + "</p>";
                errorArea.className = "visible";
              } 
              else {
                errorArea.className = "hidden";
              }
            }
            document.querySelector('#submitted').addEventListener('click', ValidateEmail);
            function ValidateEmail(e){
                const errorArea = document.querySelector('#emailErrors');
                 if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(document.querySelector("#username").value))
                  {
                    errorArea.className = "hidden";
                    return (true);
                  }else{
                    //alert("You have entered an invalid email address!");
                    e.preventDefault();
                    errorArea.innerHTML = "<p>" + "You have entered an invalid email address!" + "</p>";
                    errorArea.className = "visible";
                    return (false);
                  }
                }
        
    </script>
    </body>
</html>

<?php //Made use a small chunk of code from https://www.tutorialrepublic.com/php-tutorial/php-mysql-login-system.php
require 'services/connect.php';
if(isset($_POST['register'])){
    
    //Retrieve the field values from our registration form.
    $username = !empty($_POST['username']) ? trim($_POST['username']) : null;
    $pass = !empty($_POST['password']) ? trim($_POST['password']) : null;
    $fname = !empty($_POST['fname']) ? trim($_POST['fname']) : null;
    $lname = !empty($_POST['lname']) ? trim($_POST['lname']) : null;
    $city = !empty($_POST['city']) ? trim($_POST['city']) : null;
    $country = !empty($_POST['country']) ? trim($_POST['country']) : null;
    
    //Construct the SQL statement and prepare it.
    $sql = "SELECT COUNT(email) AS num FROM users WHERE email = :username";

    $stmt = $pdo->prepare($sql);
    
    //Bind the provided username to prepared statement.
    $stmt->bindValue(':username', $username);
    
    //Execute.
    $stmt->execute();
    
    //Fetch the row.
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
    //If the provided username already exists - display error.
    if($row['num'] > 0){
        //echo 'That username already exists! Please try again.';
        echo "
            <script>
            const errorArea = document.querySelector('#existErrors');
            errorArea.innerHTML = '<p>That username already exists! Please try again.</p>';
            errorArea.className = 'visible';
            </script>
        ";
    }
    //Hash the password as we do NOT want to store our passwords in plain text.
    else{ 
        echo "
            <script>
            const erroreArea = document.querySelector('#existErrors');
            erroreArea.innerHTML = '';
            erroreArea.className = 'hidden';
            </script>
        ";
        $passwordHash = password_hash($_POST['password'], PASSWORD_BCRYPT, array("cost" => 12));
        
        //Prepare our INSERT statement.
        //Remember: We are inserting a new row into our users table.
        $sql = "INSERT INTO users (id, email, password, firstname, lastname, city, country) VALUES ($num, :username, :password, :fname, :lname, :city, :country)";
        $stmt = $pdo->prepare($sql);
        
        //Bind our variables.
        $stmt->bindValue(':username', $username);
        $stmt->bindValue(':password', $passwordHash);
        $stmt->bindValue(':fname', $fname);
        $stmt->bindValue(':lname', $lname);
        $stmt->bindValue(':city', $city);
        $stmt->bindValue(':country', $country);
     
        //Execute the statement and insert the new account.
        $result = $stmt->execute();
        
        //If the signup process is successful.
        if($result){
            echo "
            <script>
            const errorArea = document.querySelector('#existErrors');
            errorArea.innerHTML = '<p>Congratulations! You have successful registered. Please Click Login Button to Log in With Your Email And Password!</p>';
            errorArea.className = 'visible';
            </script>
        ";
            exit;
        }
    }
}
 
?>
