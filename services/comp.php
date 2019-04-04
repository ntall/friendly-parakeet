<?php
class Comp{
 
    // database connection and table name
    private $conn;
    private $table_name = "companies";
 
    // object properties
    public $symbol;
    public $name;
    public $sector;
    public $subindustry;
    public $address;
    public $exchange;
    public $website;
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
    
    
    function read(){
 
    // select all query
    $query = "SELECT
                symbol,name,sector,subindustry,address,exchange,website
            FROM
                companies
            ORDER BY
                symbol";
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    // execute query
    $stmt->execute();
 
    return $stmt;
}

function readOne(){
 
    // query to read single record
    $query = "SELECT
                symbol,name,sector,subindustry,address,exchange,website
            FROM
                " . $this->table_name . "
            WHERE
                symbol=?
            LIMIT
                0,1";
 
    // prepare query statement
    $stmt = $this->conn->prepare( $query );
 
    // bind id of product to be updated
    $stmt->bindParam(1, $this->id);
 
    // execute query
    $stmt->execute();
 
    // get retrieved row
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
    // set values to object properties
    $this->symbol = $row['symbol'];
    $this->name = $row['name'];
    $this->sector = $row['sector'];
    $this->subindustry = $row['subindustry'];
    $this->address = $row['address'];
    $this->exchange = $row['exchange'];
    $this->website = $row['website'];
}

}
//This page completed by Yichen Li, made use some codes from https://www.codeofaninja.com/2017/02/create-simple-rest-api-in-php.html
