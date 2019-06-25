<?php
include_once 'dbh.inc.php';


$column = $_POST['column'];
$value  = $_POST['value' ];
$pky    = $_GET['client'];


	// Error handlers
	// Check for empty fields
if (empty($value)) {

	header("Location: ../client.php?client=".$pky."&edit=empty");
	exit();

} else {
		// Check if imput characters are valid
	if (!preg_match("/^[\r\n0-9a-zA-Z\ \!\?\.\,\@\-\_\:]*$/", $value)) {

		header("Location: ../client.php?client=".$pky."&edit=invalid");
		exit();

	} else {
		$sql = "UPDATE formData2 SET ".$column."='".$value."' WHERE pky = '$pky'";
		mysqli_query($conn, $sql);
		header("Location: ../client.php?client=".$pky."&edit=success");
		exit();

	}
}