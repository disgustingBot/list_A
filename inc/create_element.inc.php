<?php
session_start();
include_once 'dbh.inc.php';

$respuesta = array();

$txt = $_POST['text'];
$pty = $_POST['priority'];
$dte = $_POST['date'];
$upk = $_POST['user'];
$bse = $_POST['base'];
$parent_id = $_POST['parent'];
$grp = $_POST['group'];
// $user_id = $_POST['user_id'];
$user_id = $_SESSION['data']['pky'];


// Check for user permissions
$get_permission = "SELECT * FROM permissions WHERE (user_id = '$user_id' AND element_id = $parent_id);";
$permission = mysqli_fetch_assoc(mysqli_query($conn, $get_permission));
if($permission AND $permission['permission'] & 2){
	$respuesta['permission'] = 'can create';
} else {
	$respuesta['title'] = 'Error';
	$respuesta['message'] = "You don't have permissions to create an element here";
	echo json_encode($respuesta);
	// if user don't have permissions, prevent further execution
	exit();
}
// $element_id=$element["element_id"];
// 	$save_parent = "INSERT INTO permissions (user_id, element_id, permission) VALUES ('$user_id', '$element_id', '255');";
// 	$qry=$conn2->prepare($save_parent);
// 	$qry->execute();


// preparo el query para crear elemento de forma segura
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

$respuesta['query_test'] = $new_creation_query;



	// Error handlers
	// Check for empty fields
if (empty($txt)) {
	$respuesta['title'] = 'Error';
	$respuesta['message'] = 'empty fields';
	echo json_encode($respuesta);
	exit();
} else {
	// Insert the element into the database
	try {
		// TODO: checkear si el usuario tiene permiso para crear elemento en ese lugar

		$qry=$conn2->prepare( $new_creation_query );
		$qry->execute( $execute );
		// $element_id es el id del elemento que acabo de crear
		$element = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM elements ORDER BY element_id DESC LIMIT 1;"));
		$element_id=$element["element_id"];

		// creo la entrada en el arbol de relaciones elemento x elemento
		if ($bse!=$parent_id) {
			$save_parent = "INSERT INTO elementparent (ppk, epk) VALUES ($parent_id, $element_id);";
			$qry=$conn2->prepare($save_parent); $qry->execute();
		}

		// Para crear grupos DEPRECADO:
		// if ($grp!="") {
		// 	foreach (explode(",",$grp) as $v) {
		// 		$qry=$conn2->prepare("INSERT INTO elementparent (ppk, epk) VALUES ((SELECT pky FROM elements WHERE upk = $v AND stc = 3), $element_id);");
		// 		$qry->execute();
		// 	}
		// }


		$respuesta['title'] = 'success';
		$respuesta['message'] = 'here is your element';
		$respuesta['element'] = $element;

		// creo la entrada en la tabla de parmisos usuario x elemento
		// TODO: aqui deberia chequear que permisos darle al usuario, por ahora le forzaré el permiso mas grande
		try {
			$save_parent = "INSERT INTO permissions (user_id, element_id, permission) VALUES ('$user_id', '$element_id', '255');";
			$qry=$conn2->prepare($save_parent);
			$qry->execute();
		} catch (PDOException $e) {
			$respuesta['title'] = 'Error';
			$respuesta['message'] = 'Error: ' . $e->getMessage() . " file: " . $e->getFile() . " line: " . $e->getLine();
		}


	} catch (PDOException $e) {
		$respuesta['title'] = 'Error';
		$respuesta['message'] = 'Error: ' . $e->getMessage() . " file: " . $e->getFile() . " line: " . $e->getLine();
	}

	echo json_encode($respuesta);
	exit();
}
