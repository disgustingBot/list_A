<?php

session_start();

if (isset($_POST['submit'])) {
	
	include 'dbh.inc.php';

	// $uid = mysqli_real_escape_string($conn, $_POST['uid']);
	// $pwd = mysqli_real_escape_string($conn, $_POST['pwd']);
	$uid = $_POST['uid'];
	$pwd = $_POST['pwd'];

	// Error handlers
	// Check if inputs are empty
	if (empty($uid) || empty($pwd)) {
		header("Location: ../user.php?login=empty");
		exit();
	} else {
		$sql = "SELECT * FROM users WHERE user_uid='$uid' OR user_eml='$uid'";
		$result = mysqli_query($conn, $sql);
		$resultCheck = mysqli_num_rows($result);
		if ($resultCheck < 1) {
			header("Location: ../user.php?login=nodata");
			exit();
		} else {
			if ($row = mysqli_fetch_assoc($result)) {
				// De-hashing the password
				$hashedPwdCheck = password_verify($pwd, $row['user_pwd']);
				if ($hashedPwdCheck == false) {
					header("Location: ../user.php?login=error");
					exit();
				} elseif ($hashedPwdCheck == true) {
					// Log in the user here
					$_SESSION['u_id' ] = $row['user_id' ];
					$_SESSION['u_fst'] = $row['user_fst'];
					$_SESSION['u_lst'] = $row['user_lst'];
					$_SESSION['u_eml'] = $row['user_eml'];
					$_SESSION['u_uid'] = $row['user_uid'];
					$_SESSION['u_adm'] = $row['user_adm'];

					header("Location: ../user.php?user=".$_SESSION['u_id']);
					exit();
				}
			}
		}
	}
} else {
	header("Location: ../user.php?login=error");
	exit();
}