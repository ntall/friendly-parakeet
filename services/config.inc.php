<?php



$url = getenv('JAWSDB_URL');
$dbparts = parse_url($url);
$host = $dbparts['host'];
$username = $dbparts['user'];
$password = $dbparts['pass'];
$db_name = ltrim($dbparts['path'],'/');
define('DBCONNSTRING', "mysql:host=$hostname;dbname=$database;charset=utf8mb4;");
define('DBUSER', $username);
define('DBPASS', $password);

define('DBHOST', $host);
define('DBNAME', $db_name);
//define('DBCONNSTRING',"mysql:host=" . DBHOST . ";dbname=" . DBNAME . ";charset=utf8mb4;");

?>