<?php


foreach ($_POST as $name => $val)
{$uid = htmlspecialchars($name);}


include 'dbh.inc.php';
$sql = "DELETE FROM users WHERE user_uid = '$uid'";
mysqli_query($conn, $sql);
header("Location: ../login.php");
exit();