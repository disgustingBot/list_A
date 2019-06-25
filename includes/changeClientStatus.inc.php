<?php
include_once 'dbh.inc.php';
$pky = $_POST['clientId'];
$usr = $_POST['user'];
$stt = $_POST['state'];
$url = $_POST['url'];

if(isset($_POST['claim'])) {

	//Check if client is already claimed by user
	$sql = "SELECT * FROM clientassignments WHERE usr='$usr' AND clt='$pky'";
	$result = mysqli_query($conn, $sql);
	$resultCheck = mysqli_num_rows($result);

	if ($resultCheck > 0) {

		header("Location: ../clients.php?".$url."&claim=taken");
		exit();
			
	} else {
		$sql = "INSERT INTO clientassignments (usr, clt) VALUES ('$usr', '$pky');";
		mysqli_query($conn, $sql);
		header("Location: ../clients.php?".$url."&claim=success");
		exit();
	}

}

if (isset($_POST['test'])) {
	$sql = "UPDATE formData2 SET test='1' WHERE pky = '$pky'";
	mysqli_query($conn, $sql);
	header("Location: ../clients.php?".$url."&test=success");
	exit();
}

if(isset($_POST['state'])) {
	$sql = "UPDATE formData2 SET stt='$stt' WHERE pky = '$pky'";
	mysqli_query($conn, $sql);
	header("Location: ../clients.php?".$url."&state=success");
	exit();
}