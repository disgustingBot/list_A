<?php
include_once 'dbh.inc.php';

$tbl = $_POST['tbl'];
$col = $_POST['col'];
$val = $_POST['val'];


$ress = $conn->query("SELECT * FROM $tbl WHERE ($col = '$val')");
// $ress = $conn->query("SELECT * FROM ".$tbl." a, elements b WHERE (a.upk = ".$pky." AND a.epk = b.pky AND b.del = 0)");
$resp = $ress->fetch_all(MYSQLI_ASSOC);

// echo "hola!";
// echo json_encode($resp);
echo sizeof($resp);
// echo sprintf("%d users fetched in %s secs", count($users), number_format(microtime(true) - $startTime, 6, ".", ""));
// $conn->close();