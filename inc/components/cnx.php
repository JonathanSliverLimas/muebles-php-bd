<?php
    $server = 'localhost';
    $database = 'mueblesdb';
    $username = 'root';
    $password = '';
    $link = 'mysql:host='.$server.';dbname='.$database.';charset=utf8;';
    try{
        $cnx = new PDO($link, $username, $password);
    }catch(PDOException $ex){
        die("Error: ".$ex->getMessage());
    }
?>