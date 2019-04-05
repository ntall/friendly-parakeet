<?php
class Database{
 
 /*
$url = getenv('JAWSDB_URL');
$dbparts = parse_url($url);
$host = $dbparts['host'];
$username = $dbparts['user'];
$password = $dbparts['pass'];
$db_name = ltrim($dbparts['path'],'/');
define('DBCONNECTION', "mysql:host=$hostname;dbname=$database");
define('DBUSER', $username);
define('DBPASS', $password);

    // specify your own database credentials
    private $host = "localhost";
    private $db_name = "companies";
    private $username = "root";
    private $password = "";
    public $conn;
 */
    // get the database connection
    public function getConnection(){
 
 $url = getenv('JAWSDB_URL');
$dbparts = parse_url($url);
$host = $dbparts['host'];
$username = $dbparts['user'];
$password = $dbparts['pass'];
$db_name = ltrim($dbparts['path'],'/');
define('DBCONNECTION', "mysql:host=$hostname;dbname=$database");
define('DBUSER', $username);
define('DBPASS', $password);
 echo "failure?";
        echo "_________________________________";
        
        echo $dbparts['pass'];
        echo "_____________________________________</br>";
 echo $this->$host;
        echo "_________________________________________________<br/>";
        echo $this->$username;
        echo "_____________________<br/>";
        echo $this->$db_name;
        echo "----____---<br/>";
        echo $this->$password;
        echo "fuckkskka";

        $conn = null;
 
        try{
            $conn = new PDO("mysql:host=" . $host . ";dbname=" . $db_name, $username, $password);
             echo "fail?";

            $conn->exec("set names utf8");
        }catch(PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
        }
 
        return $this->conn;
    }
    
}
?>