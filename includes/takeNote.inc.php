<?php

// if (isset($_POST['takeNote'])) {
	
	include_once 'dbh.inc.php';


	$nte = $_POST['note'];
	$eml = $_POST['email'];


	// Error handlers
	// Check for empty fields
	if (empty($nte) || empty($eml)) {

			header("Location: ../client.php?client=".$_POST['email']."&note=empty");
		exit();

	} else {
		// Check if imput characters are valid
		// if (!preg_match("/^[\r\n0-9a-zA-Z\ \!\?\.\,\á\Á\é\É\í\Í\ó\Ó\ú\Ú]*$/", $nte) || !preg_match("/^[0-9a-zA-Z\@\.\-\_]*$/", $eml)) {
		if (preg_match("/[\']/", $nte)) {


			header("Location: ../client.php?client=".$_POST['email']."&note=invalid");
			exit();
			
		} else {
					// Insert the user into the database
			// $sql = "INSERT INTO notes (nte, eml) VALUES ('$nte', '$eml');";
			// mysqli_query($conn, $sql);


			try {
			    $qry=$conn2->prepare("INSERT INTO notes (nte, eml) VALUES ('$nte', '$eml');");
			    $qry->execute(Array(":nte" => $nte, ":eml" => $eml));
			} catch (PDOException $e) { echo 'Error: ' . $e->getMessage() . " file: " . $e->getFile() . " line: " . $e->getLine(); exit; }



			header("Location: ../client.php?client=".$_POST['email']."&note=success");
			exit();
				
		}
	}

// } else {
// 	header("Location: ../login.php");
// 	exit();
// }