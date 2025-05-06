<?php
$servername = "localhost";
$username = "root";
$password = ""; 
$dbname = "db_fruitin";

try{
     $pdo = new PDO("mysql:host=$servername;dbname=db_fruitin", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e){
    die("tidak berhasil" .$e->getMessage());
}

?>
