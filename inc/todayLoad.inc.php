<?php
include_once 'dbh.inc.php';

// $startTime = microtime(true);
// $tba = $_POST['tba'];
// $tbb = $_POST['tbb'];
// $tbc = $_POST['tbc'];
// $c1b = $_POST['c1b'];// columna 1 de tabla b
// $v1b = $_POST['v1b'];// valor   1 de tabla b
// $chd = $_POST['chd'];

$upk = $_POST['upk'];
$day = $_POST['day'];
$mnt = $_POST['mnt'];
$yar = $_POST['yar'];



// if ($chd == 0) { $fourthCondition = " AND a.chd = 0";} else {$fourthCondition = "";}

// aca la idea es que las tablas relacionales son los hilos de donde tiro, y vienen pegados los elementos relacionados
$ress = $conn->query("SELECT DISTINCT * FROM elements a, userelements b WHERE (a.del = 0 AND
	a.pky = b.epk AND
	b.upk = $upk  AND b.onf = 1    AND
	a.day = $day  AND a.mnt = $mnt AND a.yar = $yar);");

// tba va a ser elementos, tbb sera usuariosXelementos y tbc sera elementosXelementos
// $ress = $conn->query("SELECT * FROM ".$tba." a, ".$tbb." b, ".$tbc." c WHERE (a.pky = b.epk AND a.pky = c.epk AND b.upk = '$v1b' AND c.ppk = '$ppk'".$thirdCondition.$fourthCondition.");");

// $ress = $conn->query("SELECT * FROM ".$tba." a, ".$tbb." b WHERE (a.".$c1a." = '$v1a' AND a.epk = b.pky".$thirdCondition.$fourthCondition.");");
// $ress = $conn->query("SELECT * FROM ".$tbl." a, elements b WHERE (a.upk = ".$pky." AND a.epk = b.pky AND b.del = 0)");
$resp = $ress->fetch_all(MYSQLI_ASSOC);

// echo "hola!";
echo json_encode($resp);

// echo sprintf("%d users fetched in %s secs", count($users), number_format(microtime(true) - $startTime, 6, ".", ""));
// $conn->close();
