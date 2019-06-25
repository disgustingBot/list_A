<?php
include 'dbh.inc.php';



// ACA QUE PASA SI HAY OTRAS VARIABLES EN POST?
// foreach ($_POST as $name => $val)
// {$pky = htmlspecialchars($name);}
$pky = $_POST['pky'];


$sql = "UPDATE todos SET rdy='1', dnt=NOW() WHERE pky = '$pky';";
mysqli_query($conn, $sql);
if (isset($_GET['user'])) {
	# code...
	header("Location: ../user.php?user=".$_GET['user']);
} elseif (isset($_GET['client'])) {
	header("Location: ../client.php?client=".$_GET['client']);

}
exit();