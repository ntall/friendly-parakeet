<?php


function getInfo() {
   $sql = 'SELECT symbol,name,sector,subindustry,address,exchange,website FROM companies WHERE symbol=?';
   return $sql;
}

function getSingleInfo($id) {
    try {
        $connection=setConnectionInfo(DBCONNSTRING,DBUSER,DBPASS);
         $sql = getInfo();
         $statement = runQuery($connection, $sql, array($id));
         $row = $statement->fetch(PDO::FETCH_ASSOC);
         $connection = null;
         return $row; 
    }
    catch (PDOException $e) {
       die( $e->getMessage() );
    }
}
//This page Completed by Yichen Li
?>

mysql://il0f2v7rrg3knfkm:cdywomvs1cu51h32@fnx6frzmhxw45qcb.cbetxkdyhwsb.us-east-1.rds.amazonaws.com:3306/s7n6aamuapux39bs