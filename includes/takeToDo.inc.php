<?php
include_once 'dbh.inc.php';

$nte = $_POST['nte'];
$ttl = $_POST['ttl'];
$dte = $_POST['dte'];
$pty = $_POST['pty'];
$str = $_POST['str'];
if (!isset($_POST['str'])) {$str = 0;} 
$usr = $_POST['usr'];
$clt = $_POST['clt'];

	// Error handlers
	// Check for empty fields
if (empty($ttl) || empty($dte) || empty($pty)) {
	header("Location: ../client.php?client=".$_POST['clt']."&todo=empty");
	exit();
} else {
		// Check if imput characters are valid
	if (preg_match("/[\']/", $nte) || preg_match("/[\']/", $ttl)) {

		header("Location: ../client.php?client=".$_POST['clt']."&todo=invalid");
		exit();
		
	} else {
		// Insert the todo into the database

		try {
		    $qry=$conn2->prepare("INSERT INTO todos (ttl, nte, dte, str, pty) VALUES ('$ttl', '$nte', '$dte', '$str', '$pty');");
		    $qry->execute(Array(":ttl" => $ttl, ":nte" => $nte, ":dte" => $dte, ":str" => $str, ":pty" => $pty));
		} catch (PDOException $e) { echo 'Error: ' . $e->getMessage() . " file: " . $e->getFile() . " line: " . $e->getLine(); exit; }



		// tdo debe ser la pky de la tabla todos que acabo de registrar
		$sql = "SELECT pky FROM todos ORDER BY pky DESC LIMIT 1;";
		$tdo = mysqli_fetch_assoc(mysqli_query($conn, $sql));

		if (isset($usr)) {
			$sql = "INSERT INTO usertodos (tdo, usr) VALUES ('".$tdo['pky']."', '$usr');";
			mysqli_query($conn, $sql);
			header("Location: ../user.php?user=".$usr."&todo=success");
		}
		if (isset($clt)) {
			$sql = "INSERT INTO clienttodos (tdo, clt) VALUES ('".$tdo['pky']."', '$clt');";
			mysqli_query($conn, $sql);
			header("Location: ../client.php?client=".$clt."&todo=success");
		}
		exit();
		// childish gambino 
		// ver this is america music video
	}
}