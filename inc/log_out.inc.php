<?php

// if (isset($_POST['submit'])) {
	session_start();
	session_unset();
	session_destroy();
	// header("Location: ../index.php");
	if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
      $params["path"], $params["domain"],
      $params["secure"], $params["httponly"]
    );
	}

	$respuesta = array();
	$respuesta['title'] = 'Success';
	$respuesta['message'] = 'log out correcto';
	echo json_encode($respuesta);

	// echo "ok";
	// exit();
// }
