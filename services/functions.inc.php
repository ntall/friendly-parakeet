<?php
echo "not promises";
/*
  This function returns a connection object to a database
*/
function setConnectionInfo( $connString, $user, $password ) {
    echo $connString; 
    echo $user;
    echo $password;
    $pdo = new PDO($connString,$user,$password);
    echo "statement  ";
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "returning";
    return $pdo;      
}

/*
  This function runs the specified SQL query using the 
  passed connection and the passed array of parameters (null if none)
*/
function runQuery($connection, $sql, $parameters=array())     {
    // Ensure parameters are in an array
    if (!is_array($parameters)) {
        $parameters = array($parameters);
    }

    $statement = null;
    if (count($parameters) > 0) {
        // Use a prepared statement if parameters 
        $statement = $connection->prepare($sql);
        $executedOk = $statement->execute($parameters);
        if (! $executedOk) {
            throw new PDOException;
        }
    } else {
        // Execute a normal query     
        $statement = $connection->query($sql); 
        if (!$statement) {
            throw new PDOException;
        }
    }
    return $statement;
}   

?>