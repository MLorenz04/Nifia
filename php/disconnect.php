<?php 
//Odhlášení
session_start();
$_SESSION["username"] = "";
session_destroy();
header("location: ../pages/login.php");
?>