<?php

function dbConnection() {
    $DBhost = 'localhost'; // Your host name 
    $database = 'es-project';       // Your database name
    $DBuser = 'root';            // Your login userid 
    $DBpassword = '12345';            // Your password 
    
    //concatenate string for db connection 
    $dsn = 'mysql:host=';
    $dsn.=$DBhost;
    $dsn.=';dbname=';
    $dsn.=$database;
    $dsn.=';charset=utf8';

    try {
        $conPDO = new PDO($dsn, $DBuser, $DBpassword);
    } catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
    }
    return $conPDO;
}

//make a prepared query by using a PDOconnection, a string with query and an array of arguments (empty array() if there's no argument)
function queryMysqli($query, array $params) {
    $conPDO = dbConnection();
    try {
        //prepare the query
        $result = $conPDO->prepare($query);
        //execute the query with the passed parameters 
        $result->execute($params);
        //close the database connection
        $conPDO = null;
        return $result;
    } catch (PDOException $e) {
        trigger_error('Error: ' . $e->getMessage(), E_USER_ERROR);
    }
}

function get($key) {
    return filter_input(INPUT_GET, $key);
}

