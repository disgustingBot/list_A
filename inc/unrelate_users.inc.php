<?php
session_start();
include_once 'dbh.inc.php';

$respuesta = array();
// TODO: sanitizar
$userB_email = $_POST['userB_email'];
// TODO: chequear si SESSION es seguro
$user_id = $_SESSION['data']['user_id'];


function get_user_id_by_email ($email) {
	global $conn;

	// TODO: esto no es seguro, cambiar a PDO y prepared statements
  $get_user_query = "SELECT * FROM users WHERE eml = '$email';";
	$ress = $conn->query($get_user_query);
	$users = $ress->fetch_all(MYSQLI_ASSOC);

	if(isset($users[0])) {
		$user_id = $users[0]['user_id'];
		return $user_id;
	} else {
		return False;
	}
}

function is_related($user_id, $id){
	global $conn;
  $get_user_query = "SELECT * FROM user_relations WHERE (userA_id = '$user_id' AND userB_id = '$id');";
	$ress = $conn->query($get_user_query);
	$resp = $ress->fetch_all(MYSQLI_ASSOC);

	if(isset($resp[0])) {
		return True;
	} else {
		return False;
	}
}





if (get_user_id_by_email($userB_email)) {
	$userB_id = get_user_id_by_email($userB_email);

	if(is_related($user_id, $userB_id)){

		// TODO: checkear primerro si ya existe la relacion

		// preparo el query para crear elemento de forma segura
		$execute = array(
			'userA_id' => $user_id,
			'userB_id' => $userB_id,
			'relation' => 1,
		);
		$protected_columns = '(:userA_id, :userB_id, :relation)';
		$columns = '(userA_id, userB_id, relation)';

		$deletion_query = "DELETE FROM user_relations WHERE (userA_id = $user_id AND userB_id = $userB_id);";

		try {

			$qry=$conn2->prepare( $deletion_query );
			$qry->execute( $execute );

			// $get_user_query = "SELECT * FROM users WHERE pky = $userB_id;";
			// $ress = $conn->query($get_user_query);
			// $user = $ress->fetch_all(MYSQLI_ASSOC);

			$respuesta['status'] = 'report';
			$respuesta['title'] = 'You are not friends anymore';
			$respuesta['message'] = "$deletion_query";
			// $respuesta['user'] = $user;

		} catch (PDOException $e) {
			$respuesta['status'] = 'report';
			$respuesta['title'] = 'Oh oh';
			$respuesta['message'] = 'Something went terribly wrong';
			$respuesta['super_secret_message'] = 'Error: ' . $e->getMessage() . " file: " . $e->getFile() . " line: " . $e->getLine();
		}
		// $respuesta['the_user_id'] = $userB_id;

		echo json_encode($respuesta);
		exit();

	} else {
		$respuesta['status'] = 'report';
		$respuesta['title'] = 'You are not even friends...';
		$respuesta['message'] = 'what are you talking about?';
		echo json_encode($respuesta);
		exit();
	}
} else {
	$respuesta['status'] = 'report';
	$respuesta['title'] = "Sorry,";
	$respuesta['message'] = "We don't know her";
	echo json_encode($respuesta);
	exit();
}
