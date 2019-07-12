<?php include_once 'dbh.inc.php';
$uid=$_POST['uid'];
$fst=$_POST['fst'];
$lst=$_POST['lst'];
$eml=$_POST['eml'];
$pwd=$_POST['pwd'];

// Error handlers
// Check if imput characters are valid
if (preg_match("/[\']/",$uid)||preg_match("/[\']/",$fst)||preg_match("/[\']/",$lst)||preg_match("/[\']/",$eml)||preg_match("/[\']/",$pwd)) {
	echo"if";exit(); // if = invalid fields
}else{$qry="SELECT * FROM users WHERE eml = '$eml';";$ress=$conn->query($qry);$resp=$ress->fetch_all(MYSQLI_ASSOC);
	if($resp){echo"mt";exit(); // mt = mail taken
	}else{ // Insert the user into the database
		try {
			$hpw=password_hash($pwd,PASSWORD_DEFAULT); // Hashing the password
	    $qry=$conn2->prepare("INSERT INTO users (uid,fst,lst,eml,pwd) VALUES ('$uid','$fst','$lst','$eml','$hpw');");
	    $qry->execute();
			echo"ok";
		}catch(PDOException $e){echo 'Error: '.$e->getMessage()." file: ".$e->getFile()." line: ".$e->getLine();exit;}
		exit();
	}
}
