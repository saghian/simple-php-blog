<?php

$serverName = 'localhost';
$userName = 'root';
$passWord = '';
$dbName = 'toplearn-blog';

global $pdo;

try {

    $options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ);

    $pdo = new PDO("mysql:host=$serverName;dbname=$dbName", $userName, $passWord, $options);

    // echo 'connect DB!';

    return $pdo;
    

} catch (PDOException $e) {

    echo 'ERROR' . $e->getMessage();
}
