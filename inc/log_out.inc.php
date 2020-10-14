<?php

// if (isset($_POST['submit'])) {
	session_start();
	session_unset();
	session_destroy();
	// header("Location: ../index.php");

	$respuesta = array();
	$respuesta['title'] = 'Success';
	$respuesta['message'] = 'log out correcto';
	echo json_encode($respuesta);

	// echo "ok";
	// exit();
// }