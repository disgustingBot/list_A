<?php include_once 'dbh.inc.php';

$pky = $_POST['pky'];
$col = $_POST['col'];
$val = $_POST['val'];

try {
	$qry=$conn2->prepare("UPDATE elements SET $col = '$val' WHERE (pky=$pky);");
	$qry->execute();
} catch (PDOException $e) {echo 'Error: '.$e->getMessage()." file: ".$e->getFile()." line: ".$e->getLine(); exit;}

echo $pky;
