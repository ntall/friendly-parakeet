<?php
    session_start();
    require 'services/connect.php';
    require 'header.php';
?>
<?php
    if(isset($_SESSION['user_id']))
    {
                    $userid=$_SESSION['user_id'];
                    $sql = "SELECT id, firstname, lastname, city, country, email FROM users WHERE id = :id";
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindValue(':id', $userid);
                    $stmt->execute();
                    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
        <link rel="stylesheet" type="text/css" href="asg2.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>
    <body>
        <main>
            <h2>Profile</h2>
            <div>
                <?php 
                    echo "<img src='https://randomuser.me/api/portraits/women/".$user['id'].".jpg'>";
                ?>
            </div>
            <div>
                <table id='profile'>
                    <tbody>
                        <tr>
                            <td>Name:</td>
                            <td><?php echo $user['firstname'] . " " . $user['lastname']; ?></td>
                        </tr>
                        <tr>
                            <td>City:</td>
                            <td ><?php echo $user['city']; ?></td>
                        </tr>
                        <tr>
                            <td>Country:</td>
                            <td><?php echo $user['country']; ?></td>
                        </tr>
                        <tr>
                            <td>Email Address:</td>
                            <td><?php echo $user['email']; ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </main>
    </body>
 
</html>