<?php


function getInfo() {
   $sql = 'SELECT symbol,name,sector,subindustry,address,exchange,website FROM companies WHERE symbol=?';
   return $sql;
}

function getSingleInfo($id) {
    try {
        $connection=setConnectionInfo(DBCONNSTRING,DBUSER,DBPASS);
         $sql = getInfo();
        echo $sql;
         $statement = runQuery($connection, $sql, array($id));
         $row = $statement->fetch(PDO::FETCH_ASSOC);
         $connection = null;
         return $row; 
    }
    catch (PDOException $e) {
       die( $e->getMessage() );
    }
}
?>

