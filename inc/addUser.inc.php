<?php
include_once 'dbh.inc.php';

$uid = $_POST['uid'];
$fst = $_POST['fst'];
$lst = $_POST['lst'];
$eml = $_POST['eml'];
$pwd = $_POST['pwd'];

	// Error handlers
	// Check if imput characters are valid
	if (preg_match("/[\']/", $uid)||preg_match("/[\']/", $fst)||preg_match("/[\']/", $lst)||preg_match("/[\']/", $eml)||preg_match("/[\']/", $pwd)) {
	// if (preg_match("/[\']/", $nte) || preg_match("/[\']/", $ttl)) {

		// header("Location: ../client.php?client=".$_POST['clt']."&todo=invalid");
		echo "invalid fields";
		exit();
		
	} else {
		// Insert the todo into the database

		try {
			// Hashing the passwordltGeQSSjPU9dDpfl
			$hpw = password_hash($pwd, PASSWORD_DEFAULT);

		    $qry=$conn2->prepare("INSERT INTO users (uid, fst, lst, eml, pwd) VALUES ('$uid', '$fst', '$lst', '$eml', '$hpw');");
		    // $qry=$conn2->prepare("INSERT INTO todos (ttl, nte, dte, str, pty) VALUES ('$ttl', '$nte', '$dte', '$str', '$pty');");
		    $qry->execute();
		    // $qry->execute(Array(":txt" => $txt));
		    // $qry->execute(Array(":ttl" => $ttl, ":nte" => $nte, ":dte" => $dte, ":str" => $str, ":pty" => $pty));
			echo "ok";
		} catch (PDOException $e) { echo 'Error: ' . $e->getMessage() . " file: " . $e->getFile() . " line: " . $e->getLine(); exit; }

		exit();
	}


// user = Zack
// pass = ltGeQSSjPU9dDpfl

	