<?php
// required headers
header("Content-Type: application/json; charset=UTF-8");

// include database and object files
include_once 'database.php';
include_once 'comp.php';

// instantiate database and company object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$company = new Comp($db);


// query company
$stmt = $company->read();
$num = $stmt->rowCount();


// check if more than 0 record found
if(!isset($_GET['id'])){
 
    // company array
    $comp_arr=array();
    
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 
        $comp_item=array(
            "symbol" => $symbol,
            "name" => $name,
            "sector" => $sector,
            "subindustry" => $subindustry,
            "address" => $address,
            "exchange" => $exchange,
            "website" => $website
        );

        array_push($comp_arr, $comp_item);
    }

    // show companies data in json format
    echo json_encode($comp_arr);
}


// no companies found will be here
// set ID property of record to read
$company->id = isset($_GET['id']) ? $_GET['id'] : die();
 
// read the details of company to be edited
$company->readOne();
if(isset($_GET['id']) && $company->name!=null){
    
    // create array
    $comp_arr = array(
        "symbol" => $company->symbol,
        "name" => $company->name,
        "sector" => $company->sector,
        "subindustry" => $company->subindustry,
        "address" => $company->address,
        "exchange" => $company->exchange,
        "website" => $company->website

    );
 
    echo json_encode($comp_arr);
    
    
}
else{
 
 
    // tell the user no companies found
    echo json_encode(
        array("message" => "No company found.")
    );
}

?>
<!--
    used some codes from https://www.codeofaninja.com/2017/02/create-simple-rest-api-in-php.html
-->
