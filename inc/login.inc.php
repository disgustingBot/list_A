<?php


// pky = primary key
// tsp = time stamp
// txt = texto
// tck = ticked
// pty = priority
// pbt = primary button
// trk = traking
// arc = archived  (boolean 0 = elemento visible, 1 = elemento archivado)
// del = deleted   (boolean 0 = por defecto,      1 = el elemento ha sido eliminado)
// chd = child     (boolean 0 = no tiene padre,   1 = tiene padre)
// fvt = favourite (boolean 0 = no es favorito,   1 = es favorito)
// clr = color
// epk = element primary key
// ppk = parent  primary key
// tpk = tag     primary key
// onf = on or off

// DATOS DE BASE DE DATOS
// user = list-a_master
// pass = 2epOrRrPEvXHjYG6

// DATOS DE USUARIO
// user = Zack
// pass = ltGeQSSjPU9dDpfl

session_start();
include 'dbh.inc.php';

// $uid = mysqli_real_escape_string($conn, $_POST['uid']);
// $pwd = mysqli_real_escape_string($conn, $_POST['pwd']);
$log = $_POST['log'];
$pwd = $_POST['pwd'];

// Error handlers
// Check if inputs are empty
if (empty($log) || empty($pwd)) {
	// echo "login empty";
	$_SESSION['status'] = "login empty";
	echo json_encode($_SESSION);
	// header("Location: ../user.php?login=empty");
	exit();
} else {
	$sql = "SELECT * FROM users WHERE uid='$log' OR eml='$log'";
	$result = mysqli_query($conn, $sql);
	$resultCheck = mysqli_num_rows($result);
	if ($resultCheck < 1) {
		// header("Location: ../user.php?login=nodata");
		// echo "login nodata";
		$_SESSION['status'] = "login nodata";
		echo json_encode($_SESSION);
		exit();
	} else {
		if ($row = mysqli_fetch_assoc($result)) {
			// De-hashing the password
			$hashedPwdCheck = password_verify($pwd, $row['pwd']);
			if ($hashedPwdCheck == false) {
				// header("Location: ../user.php?login=error");
				// echo "login error";
				$_SESSION['status'] = "login error";
				echo json_encode($_SESSION);
				exit();
			} elseif ($hashedPwdCheck == true) {
				// Log in the user here
				$_SESSION['status'] = "ok";

				$_SESSION['u_pky'] = $row['pky'];
				$_SESSION['u_uid'] = $row['uid'];
				$_SESSION['u_fst'] = $row['fst'];
				$_SESSION['u_lst'] = $row['lst'];
				$_SESSION['u_eml'] = $row['eml'];

				echo json_encode($_SESSION);
				
				exit();
			}
		}
	}
}