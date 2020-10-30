<?php


// // $dbServerName = "localhost";
// // $dbUserName = "lattedev_list-a";
// // $dbPassword = "2epOrRrPEvXHjYG6";
// // $dbName = "lattedev_list-a";
// // $pdo_dsn='mysql:dbname=lattedev_list-a;host=localhost'; $pdo_user='lattedev_list-a'; $pdo_password='2epOrRrPEvXHjYG6';

// Datos de acceso online

// $dbServerName = "localhost";
// $dbUserName = "lattedev_lista";
// $dbPassword = "2epOrRrPEvXHjYG6";
// $dbName = "lattedev_lista";
//
// $pdo_dsn='mysql:dbname=lattedev_lista;host=localhost'; $pdo_user='lattedev_lista'; $pdo_password='2epOrRrPEvXHjYG6';




// Datos de acceso local

$dbServerName = "localhost";
$dbUserName = "list-a_master";
$dbPassword = "2epOrRrPEvXHjYG6";
$dbName = "list-a";

$pdo_dsn='mysql:dbname=list-a;host=localhost'; $pdo_user='list-a_master'; $pdo_password='2epOrRrPEvXHjYG6';




// user = list-a_master
// pass = 2epOrRrPEvXHjYG6
$conn = mysqli_connect($dbServerName, $dbUserName, $dbPassword, $dbName);
$conn2 = new PDO($pdo_dsn, $pdo_user, $pdo_password);

$conn2->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
$conn2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
