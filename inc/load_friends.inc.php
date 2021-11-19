<?php
session_start();
include_once 'dbh.inc.php';


$user_id = $_SESSION['data']['user_id'];



// algoritmo


// get all relations that link the user
$qry = "SELECT DISTINCT *
	FROM user_relations WHERE (
		userA_id = '$user_id'
	)";
$ress = $conn->query($qry);
$resp = $ress->fetch_all(MYSQLI_ASSOC);


// user could be A or B
// make a list of users != user
$my_friends = array();
foreach ($resp as $key => $value) {
	$my_friends[] = $value['userB_id'];
}



// get all users from the list
$my_friends = implode(',', array_map('intval', $my_friends));

$qry = "SELECT * FROM `users` WHERE (user_id IN ($my_friends))";
// $qry = "SELECT (`pky`, `upk`, `fst`, `lst`) FROM `users` WHERE (pky IN ($my_friends))";

// aca la idea es que las tablas relacionales son los hilos de donde tiro, y vienen pegados los elementos relacionados
$ress = $conn->query($qry);
$resp = $ress->fetch_all(MYSQLI_ASSOC);
// $respuesta = array();
// $respuesta['qry'] = $qry;
// $respuesta['list'] = $my_friends;
echo json_encode($resp);
