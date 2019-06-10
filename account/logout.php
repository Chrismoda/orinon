<?php
session_start();


$_SESSION['NatID'] = null;
$_SESSION['Alias'] = null;

header("location: ../index.php");
exit();

 ?>