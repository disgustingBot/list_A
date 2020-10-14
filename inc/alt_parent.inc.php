<?php
include_once 'dbh.inc.php';

$ppk = $_POST['ppk'];
$epk = $_POST['epk'];

$respuesta = array();


// debo fijarme si el elemento ya tiene ese padre asignado y en caso afirmativo, desactivarlo
$qry = "SELECT *
	FROM
	elements e, elementparent p
	WHERE (
	e.del  = 0     AND e.element_id = $epk AND
	e.element_id  = p.epk AND
	p.ppk = $ppk  AND p.onf = 1
);";
// $respuesta['query'] = $qry;
// echo $qry;
$ress=$conn->query($qry);
$resp=$ress->fetch_all(MYSQLI_ASSOC);

if ($resp) {
	// echo "Element is already a son o P";
	// echo $qry;
	try {
		$respuesta['title'] = 'Success';
		$respuesta['message'] = 'remove parent';
		$respuesta['already_related'] = 1;

		// echo 0;
		// $qry=$conn2->prepare("UPDATE elements SET $col = $val WHERE (pky=$pky);");
		$qry=$conn2->prepare("UPDATE elementparent SET onf = 0 WHERE epk = $epk AND ppk = $ppk;"); $qry->execute();
	} catch (PDOException $e) {
		$respuesta['title'] = 'Error';
		$respuesta['message'] = 'Error: ' . $e->getMessage() . " file: " . $e->getFile() . " line: " . $e->getLine();
		// exit;
	}
} else {
	// Element is NOT a fav
	// Insert the element into the database
	try {
		$respuesta['title'] = 'Success';
		$respuesta['message'] = 'add parent';
		$respuesta['already_related'] = 0;
		// echo 1;
		$qry=$conn2->prepare("INSERT INTO elementparent (ppk, epk) VALUES ('$ppk', '$epk');"); $qry->execute();
	} catch (PDOException $e) {
		$respuesta['title'] = 'Error';
		$respuesta['message'] = 'Error: ' . $e->getMessage() . " file: " . $e->getFile() . " line: " . $e->getLine();
		// exit;
	}
}
echo json_encode($respuesta);

exit();
