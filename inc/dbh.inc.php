<?php 


// $dbServerName = "localhost";
// $dbUserName = "lattedev_list-a";
// $dbPassword = "2epOrRrPEvXHjYG6";
// $dbName = "lattedev_list-a";


// user = list-a_master
// pass = 2epOrRrPEvXHjYG6



// Datos de acceso local

$dbServerName = "localhost";
$dbUserName = "list-a_master";
$dbPassword = "2epOrRrPEvXHjYG6";
$dbName = "list-a";

$conn = mysqli_connect($dbServerName, $dbUserName, $dbPassword, $dbName);




// $pdo_dsn='mysql:dbname=lattedev_list-a;host=localhost'; $pdo_user='lattedev_list-a'; $pdo_password='2epOrRrPEvXHjYG6'; 
$pdo_dsn='mysql:dbname=list-a;host=localhost'; $pdo_user='list-a_master'; $pdo_password='2epOrRrPEvXHjYG6';  


$conn2 = new PDO($pdo_dsn, $pdo_user, $pdo_password);
$conn2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);