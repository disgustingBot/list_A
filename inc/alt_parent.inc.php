<?php
include_once 'dbh.inc.php';

$ppk = $_POST['ppk'];
$epk = $_POST['epk'];


// debo fijarme si el elemento ya tiene ese padre asignado y en caso afirmativo, desactivarlo
$qry = "SELECT *
	FROM
	elements e, elementparent p
	WHERE (
	e.del  = 0     AND e.element_id = $epk AND
	e.element_id  = p.epk AND
	p.ppk = $ppk  AND p.onf = 1
);";
// echo $qry;
$ress=$conn->query($qry);$resp=$ress->fetch_all(MYSQLI_ASSOC);

if ($resp) {
	// echo "Element is already a son o P";
	// echo $qry;
	try {echo 0;
		// $qry=$conn2->prepare("UPDATE elements SET $col = $val WHERE (pky=$pky);");
		$qry=$conn2->prepare("UPDATE $tbl SET onf = 0 WHERE epk = $epk AND $col = $val;"); $qry->execute();
	} catch (PDOException $e) { echo 'Error: ' . $e->getMessage() . " file: " . $e->getFile() . " line: " . $e->getLine(); exit; }
} else {
	// Element is NOT a fav
	// Insert the element into the database
	try {echo 1;
		$qry=$conn2->prepare("INSERT INTO $tbl ($col, epk) VALUES ('$val', '$epk');"); $qry->execute();
	} catch (PDOException $e) { echo 'Error: ' . $e->getMessage() . " file: " . $e->getFile() . " line: " . $e->getLine(); exit; }
}
// echo json_encode($resp);

exit();
