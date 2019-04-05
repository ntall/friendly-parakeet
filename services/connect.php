<?php
 
 $url = getenv('JAWSDB_URL');
$dbparts = parse_url($url);
$host = $dbparts['host'];
$username = $dbparts['user'];
$password = $dbparts['pass'];
$db_name = ltrim($dbparts['path'],'/');
 
//Our MySQL user account.
define('MYSQL_USER', $username);
 
//Our MySQL password.
define('MYSQL_PASSWORD', $password);
 
//The server that MySQL is located on.
define('MYSQL_HOST', $host);
 
//The name of our database.
define('MYSQL_DATABASE', $db_name);
 
$pdoOptions = array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_EMULATE_PREPARES => false
);
 

$pdo = new PDO(
    "mysql:host=" . MYSQL_HOST . ";dbname=" . MYSQL_DATABASE, //DSN
    MYSQL_USER, //Username
    MYSQL_PASSWORD, //Password
    $pdoOptions //Options
);


$sql = "select count(*) from  users";
$stmt = $pdo->prepare($sql);
$stmt->execute();
//for id increment after new registration
$num = $stmt->fetchColumn()+1;

//Made use code from https://www.tutorialrepublic.com/php-tutorial/php-mysql-login-system.php