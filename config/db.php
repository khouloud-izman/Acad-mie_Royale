<?php
$host = 'localhost';
$dbName = 'patisserie_royale';
$user = 'root';
$pass = '';

try{
    $pdo = new PDO("mysql:host=$host;dbname=$dbName;",$user,$pass);
    $pdo->setAttribute(PDO :: ATTR_ERRMODE , PDO :: ERRMODE_EXCEPTION);
}catch(PDOExecpetion $ex){
    die('echec de la connexion' .$ex->getMessage());
}


?>