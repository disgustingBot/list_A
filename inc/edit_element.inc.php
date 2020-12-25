<?php
// TODO: checkear por permisos primero
session_start();
include_once 'dbh.inc.php';

$element_id = $_POST['element_id'];
$key = $_POST['key'];
$value = $_POST['value'];
$user_id = $_SESSION['data']['pky'];

$respuesta = array();

// Check for user permissions
$get_permission = "SELECT * FROM permissions WHERE (user_id = '$user_id' AND element_id = $element_id);";
$permission = mysqli_fetch_assoc(mysqli_query($conn, $get_permission));
$required = 4;
$message = "edit";
if($key == 'del'){
	$required = 8;
	$message = "delete";
}
if($permission AND $permission['permission'] & $required){
	$respuesta['permission'] = 'can do it';
} else {
	$respuesta['title'] = 'Error';
	$respuesta['message'] = "You don't have permissions to $message that";
	echo json_encode($respuesta);
	// if user don't have permissions, prevent further execution
	exit();
}

try {
	$update_query = "UPDATE elements SET $key = :value WHERE ( element_id = $element_id );";
	$select_query = "SELECT * FROM elements WHERE ( element_id = $element_id AND del = 0 );";

	$respuesta['title'] = 'Success';
	$respuesta['message'] = 'Elemento editado';
	// $respuesta['query'] = $query;

	$update =  $conn2->prepare( $update_query );
	$update -> execute( ['value' => $value] );

	$ress = $conn->query($select_query);
	$resp = $ress->fetch_all(MYSQLI_ASSOC);

	$respuesta['element'] = $resp[0];


} catch (PDOException $e) {
	$respuesta['title'] = 'Error';
	$respuesta['message'] = 'Error: '.$e->getMessage()." file: ".$e->getFile()." line: ".$e->getLine();
}

echo json_encode($respuesta);
