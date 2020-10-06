<?php
include_once 'dbh.inc.php';

$txt = $_POST['txt'];
$pty = $_POST['pty'];
$dte = $_POST['dte'];
$upk = $_POST['upk'];
$bse = $_POST['bse'];
$ppk = $_POST['ppk'];
$grp = $_POST['grp'];

$columns = '(txt, pty, ';
$values  = "('$txt', '$pty', ";
if($dte != ''){
	// $dte = NULL;
	$columns = $columns . 'dte, ';
	$values = $values . "'$dte', ";
}
if($upk != ''){
	// $upk = NULL;
	$columns = $columns . 'upk, ';
	$values = $values . "'$upk', ";
}
$columns = $columns . 'bse)';
$values = $values . "'$bse')";

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
			$creation_query = "INSERT INTO elements $columns VALUES $values;";
			// $creation_query = "INSERT INTO elements (txt, pty, dte, upk, bse) VALUES ('$txt', '$pty', '$dte', '$upk', '$bse');";
			// echo $creation_query;
			$qry=$conn2->prepare( $creation_query ); $qry->execute();

			// $epk['pky'] debe ser la pky del elemento que acabo de registrar
			$epk = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM elements ORDER BY pky DESC LIMIT 1;")); $pky=$epk["pky"];
			if ($bse!=$ppk) {
				$qry=$conn2->prepare("INSERT INTO elementparent (ppk, epk) VALUES ($ppk, $pky);"); $qry->execute();
			}
			// echo json_encode($epk["pky"]);
			// echo var_dump(explode(",",$grp));
			if ($grp!="") {
				foreach (explode(",",$grp) as $v) {
					$qry=$conn2->prepare("INSERT INTO elementparent (ppk, epk) VALUES ((SELECT pky FROM elements WHERE upk = $v AND stc = 3), $pky);"); $qry->execute();
					// echo $v;
				}
			}

			// var_dump($grp);
			// echo $creation_query;
			echo json_encode($epk);

		} catch (PDOException $e) { echo 'Error: ' . $e->getMessage() . " file: " . $e->getFile() . " line: " . $e->getLine(); exit; }

		exit();
	}
}
