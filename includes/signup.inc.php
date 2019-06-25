<?php

if (isset($_POST['submit'])) {
	
	include_once 'dbh.inc.php';

	// $fst = mysqli_real_escape_string($conn, $_POST['fst']);
	// $lst = mysqli_real_escape_string($conn, $_POST['lst']);
	// $eml = mysqli_real_escape_string($conn, $_POST['eml']);
	// $uid = mysqli_real_escape_string($conn, $_POST['uid']);
	// $pwd = mysqli_real_escape_string($conn, $_POST['pwd']);


	$fst = $_POST['fst'];
	$lst = $_POST['lst'];
	$eml = $_POST['eml'];
	$uid = $_POST['uid'];
	$pwd = $_POST['pwd'];
	if (isset($_POST['adm'])) {$adm = 1;} else {$adm = 0;}


	// Error handlers
	// Check for empty fields
	if (empty($fst) || empty($lst) || empty($eml) || empty($uid) || empty($pwd)) {

		header("Location: ../login.php?signup=empty");
		exit();

	} else {
		// Check if imput characters are valid
		if (!preg_match("/^[a-zA-Z]*$/", $fst) || !preg_match("/^[a-zA-Z]*$/", $lst)) {

			header("Location: ../login.php?signup=invalid");
			exit();
			
		} else {
			// Check if email is valid
			if (!filter_var($eml, FILTER_VALIDATE_EMAIL)) {

				header("Location: ../login.php?signup=email");
				exit();
			
			} else {
				//Check if user id is taken
				$sql = "SELECT * FROM users WHERE user_uid='$uid'";
				$result = mysqli_query($conn, $sql);
				$resultCheck = mysqli_num_rows($result);

				if ($resultCheck > 0) {

					header("Location: ../login.php?signup=usertaken");
					exit();
			
				} else {
					// Hashing the password
					$hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);
					// Insert the user into the database
					$sql = "INSERT INTO users (user_fst, user_lst, user_eml, user_uid, user_pwd, user_adm) VALUES ('$fst', '$lst', '$eml', '$uid', '$hashedPwd', '$adm');";
					mysqli_query($conn, $sql);
					header("Location: ../index.php?signup=success");
					exit();
				}
			}
		}
	}

} else {
	header("Location: ../login.php");
	exit();
}