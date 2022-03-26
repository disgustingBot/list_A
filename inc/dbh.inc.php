<?php




function get_db_connection(){
    $config_file = "config.ini";
    $config = parse_ini_file($config_file, true);
    $db_host = $config["access_data"]["host"];
    $db_user = $config["access_data"]["user"];
    $db_pass = $config["access_data"]["pass"];
    $db_name = $config["access_data"]["name"];

    $pdo_dsn='mysql:dbname='.$db_name.';host='.$db_host;
    $conn2 = new PDO($pdo_dsn, $db_user, $db_pass);
    
    $conn2->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $conn2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $conn2;
}

// echo $config["access_data"]["host"];


$config_file = "config.ini";
$config = parse_ini_file($config_file, true);

$db_host = $config["access_data"]["host"];
$db_user = $config["access_data"]["user"];
$db_pass = $config["access_data"]["pass"];
$db_name = $config["access_data"]["name"];





$pdo_dsn='mysql:dbname='.$db_name.';host='.$db_host;
$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
$conn2 = new PDO($pdo_dsn, $db_user, $db_pass);

$conn2->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
$conn2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);