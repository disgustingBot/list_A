<?php include_once 'dbh.inc.php';
$uid=$_POST['uid'];
$fst=$_POST['fst'];
$lst=$_POST['lst'];
$eml=$_POST['eml'];
$pwd=$_POST['pwd'];
$respuesta = array();

// Error handlers
// Check if imput characters are valid
if(preg_match("/[\']/",$uid)||preg_match("/[\']/",$fst)||preg_match("/[\']/",$lst)||preg_match("/[\']/",$eml)||preg_match("/[\']/",$pwd)) {
	$respuesta['error']='invalid characters used';
	echo json_encode($respuesta);
	// echo"if";
	exit(); // if = invalid fields
}else{$qry="SELECT * FROM users WHERE eml = '$eml';";$ress=$conn->query($qry);$resp=$ress->fetch_all(MYSQLI_ASSOC);
	if($resp){
		$respuesta['title']='Error';
		$respuesta['message']='this mail already has an account';
		echo json_encode($respuesta);
		// echo"mt";
		exit(); // mt = mail taken
	}else{$qry="SELECT * FROM users WHERE uid = '$uid';";$ress=$conn->query($qry);$resp=$ress->fetch_all(MYSQLI_ASSOC);
		if($resp){
			$respuesta['title']='Error';
			$respuesta['message']='this user name is already taken';
			echo json_encode($respuesta);
			// echo"ut";
			exit(); // ut = user taken
		}else{ // Insert the user into the database
			try{
				$hpw=password_hash($pwd,PASSWORD_DEFAULT); // Hashing the password
				$qry=$conn2->prepare("INSERT INTO users (uid,fst,lst,eml,pwd) VALUES ('$uid','$fst','$lst','$eml','$hpw');");
				$qry->execute();
				// $epk = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users ORDER BY pky DESC LIMIT 1;"));

				$respuesta['title']='Success';
				$respuesta['message']='se ha creado la cuenta';
				echo json_encode($respuesta);
				// echo"ok";
			}catch(PDOException $e){
				// echo 'Error: '.$e->getMessage()." file: ".$e->getFile()." line: ".$e->getLine();
				$respuesta['title']='Error';
				$respuesta['message']='Error: '.$e->getMessage()." file: ".$e->getFile()." line: ".$e->getLine();
				echo json_encode($respuesta);
				exit;
			}
			exit();
		}
	}
}
