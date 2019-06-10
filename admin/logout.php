<?php
session_start();


$_SESSION['AdminNatID'] = null;
$_SESSION['AdminAlias'] = null;

header("location: ../index.php");
exit();

 ?>