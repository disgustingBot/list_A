<?php
include_once 'dbh.inc.php';

$element_id = $_POST['element_id'];
$key = $_POST['key'];
$value = $_POST['value'];

$respuesta = array();
$respuesta['test'] = 'test';

try {
	$update_query = "UPDATE elements SET $key = '$value' WHERE ( element_id = $element_id );";
	$select_query = "SELECT * FROM elements WHERE ( element_id = $element_id AND del = 0 );";

	// $qry=$conn2->prepare("UPDATE elements SET $key = '$value' WHERE ( pky = $element_id );");
	// $qry->execute();
	$respuesta['title'] = 'Success';
	$respuesta['message'] = 'Elemento editado';
	// $respuesta['query'] = $query;


	// $qry = "SELECT DISTINCT * FROM elements WHERE (pky = $element_id AND del = 0 );";
	$ress = $conn->query($update_query);
	$ress = $conn->query("COMMIT;");
	$ress = $conn->query($select_query);
	$resp = $ress->fetch_all(MYSQLI_ASSOC);

	$respuesta['element'] = $resp[0];
	// echo "hola!";
	// echo $e;
	// echo json_encode($resp);



} catch (PDOException $e) {
	// echo 'Error: '.$e->getMessage()." file: ".$e->getFile()." line: ".$e->getLine();
	$respuesta['title'] = 'Error';
	$respuesta['message'] = 'Error: '.$e->getMessage()." file: ".$e->getFile()." line: ".$e->getLine();
	// exit;
}

echo json_encode($respuesta);
// echo $element_id;
