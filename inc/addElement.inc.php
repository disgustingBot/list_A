<?php
include_once 'dbh.inc.php';

$txt = $_POST['txt'];
$pty = $_POST['pty'];
$dte = $_POST['dte'];
$bse = $_POST['bse'];


	// Error handlers
	// Check for empty fields
if (empty($txt)) {
	// echo "empty fields";
	echo json_encode("empty fields");
	exit();
} else {
		// Check if imput characters are valid
	if (preg_match("/[\']/", $txt)) {
		// echo "invalid fields";
		echo json_encode("invalid fields");
		exit();
	} else {
		// Insert the element into the database
		try {
		  $qry=$conn2->prepare("INSERT INTO elements (txt, pty, dte, bse) VALUES ('$txt', '$pty', '$dte', '$bse');"); $qry->execute();

			// $epk['pky'] debe ser la pky del elemento que acabo de registrar
			$epk = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM elements ORDER BY pky DESC LIMIT 1;"));
		    // $qry=$conn2->prepare("INSERT INTO userelements (epk, upk) VALUES ('".$epk['pky']."', '$upk');"); $qry->execute();

			echo json_encode($epk);

		} catch (PDOException $e) { echo 'Error: ' . $e->getMessage() . " file: " . $e->getFile() . " line: " . $e->getLine(); exit; }

		exit();
	}
}
