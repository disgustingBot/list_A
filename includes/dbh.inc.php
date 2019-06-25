<?php 


// $dbServerName = "localhost";
// $dbUserName = "loginUser";
// $dbPassword = "test123";
// $dbName = "loginSystem";


// user = list-a_master
// pass = 2epOrRrPEvXHjYG6



$dbServerName = "localhost";
$dbUserName = "list-a_master";
$dbPassword = "2epOrRrPEvXHjYG6";
$dbName = "list-a";

$conn = mysqli_connect($dbServerName, $dbUserName, $dbPassword, $dbName);




// $pdo_dsn='mysql:dbname=loginSystem;host=localhost'; $pdo_user='loginUser'; $pdo_password='test123'; 
$pdo_dsn='mysql:dbname=list-a;host=localhost'; $pdo_user='list-a_master'; $pdo_password='2epOrRrPEvXHjYG6';  


$conn2 = new PDO($pdo_dsn, $pdo_user, $pdo_password);
$conn2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);