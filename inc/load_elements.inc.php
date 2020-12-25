<?php
session_start();
include_once 'dbh.inc.php';

$parent_id = $_POST['ppk'];
// $user_id = $_POST['user_id'];
$user_id = $_SESSION['data']['pky'];




// $tdy = $_POST['tdy'];
// if ($tdy) {
	// $qry = "SELECT DISTINCT *
	// 	FROM
	// 	elements a, elementparent b
	// 	WHERE (
	// 	a.del = 0      AND
	// 	a.bse = (SELECT bse FROM elements WHERE pky = ppk) AND
	// 	DATE(a.dte) >= CURDATE()         AND
	// 	DATE(a.dte) <  CURDATE() + INTERVAL 1 DAY
	// );";
// } else {
	$qry = "SELECT DISTINCT *
		FROM
		elements a, elementparent b, permissions c
		WHERE (
			a.element_id = b.epk AND a.del = 0 AND
			b.ppk = $parent_id  AND b.onf = 1 AND
			a.element_id = c.element_id AND c.user_id = $user_id AND c.permission >= 1
		);";
// }
// echo var_dump($tdy);
// aca la idea es que las tablas relacionales son los hilos de donde tiro, y vienen pegados los elementos relacionados
$ress = $conn->query($qry);
$resp = $ress->fetch_all(MYSQLI_ASSOC);

// echo "hola!";
// echo $e;
echo json_encode($resp);

// echo sprintf("%d users fetched in %s secs", count($users), number_format(microtime(true) - $startTime, 6, ".", ""));
// $conn->close();
