<?php
include_once 'dbh.inc.php';

$respuesta = array();

$txt = $_POST['text'];
$pty = $_POST['priority'];
$dte = $_POST['date'];
$upk = $_POST['user'];
$bse = $_POST['base'];
$ppk = $_POST['parent'];
$grp = $_POST['group'];

// $preparedStatement = $db->prepare('INSERT INTO table (column) VALUES (:column)');
// $preparedStatement->execute([ 'column' => $unsafeValue ]);

$execute = array(
	'txt' => $txt,
	'pty' => $pty,
);
$protected_columns = '(:txt, :pty, ';

$columns = '(txt, pty, ';
if($dte != ''){
	$execute['dte'] = $dte;
	$protected_columns .= ':dte, ';
	$columns .= 'dte, ';
}
if($upk != ''){
	$execute['upk'] = $upk;
	$protected_columns .= ':upk, ';
	$columns .= 'upk, ';
}
$execute['bse'] = $bse;
$protected_columns .= ':bse)';

$columns .= 'bse)';


$new_creation_query = "INSERT INTO elements $columns VALUES $protected_columns;";



	// Error handlers
	// Check for empty fields
if (empty($txt)) {
	// echo "empty fields";
	// echo json_encode("empty fields");
	$respuesta['title'] = 'error';
	$respuesta['message'] = 'empty fields';
	echo json_encode($respuesta);
	exit();
} else {
	// Insert the element into the database
	try {
		$qry=$conn2->prepare( $new_creation_query );
		$qry->execute( $execute );

		// $epk['pky'] debe ser la pky del elemento que acabo de registrar
		$epk = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM elements ORDER BY element_id DESC LIMIT 1;"));
		// $epk['txt'] = nl2br( $epk['txt'] );
		// $epk['txt'] .= '123';
		$pky=$epk["element_id"];
		if ($bse!=$ppk) {
			$save_parent = "INSERT INTO elementparent (ppk, epk) VALUES ($ppk, $pky);";
			$qry=$conn2->prepare($save_parent); $qry->execute();
		}
		// echo json_encode($epk["pky"]);
		// echo var_dump(explode(",",$grp));
		if ($grp!="") {
			foreach (explode(",",$grp) as $v) {
				$qry=$conn2->prepare("INSERT INTO elementparent (ppk, epk) VALUES ((SELECT pky FROM elements WHERE upk = $v AND stc = 3), $pky);");
				$qry->execute();
				// echo $v;
			}
		}
		// "INSERT INTO elementparent (ppk, epk) VALUES (768, 787);"
		// var_dump($grp);
		// echo $creation_query;
		// echo json_encode($epk);
		$respuesta['title'] = 'success';
		$respuesta['message'] = 'here is your element';
		$respuesta['element'] = $epk;
		// $respuesta['ppk'] = $ppk;
		// $respuesta['pky'] = $pky;
		// $respuesta['save_parent'] = $save_parent;
		// $respuesta['creation_query'] = $creation_query;
		echo json_encode($respuesta);

	} catch (PDOException $e) { echo 'Error: ' . $e->getMessage() . " file: " . $e->getFile() . " line: " . $e->getLine(); exit; }

	exit();
}
