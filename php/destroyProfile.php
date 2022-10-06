<?php 
require ".././components/database.php";
require "./check.php";
$errors = new Check();
session_start();
$username = $_SESSION["username"];
//Jednotlivé SQL příkazy
$sql = "delete from user where username='$username'";
$sql2 = "delete from contribution where author='$username'";
$sql3 = "delete from follows where follower='$username' OR following='$username'";
//Jejich kontrola proti pokusu o hacknutí stránky a následné provedení
if($errors -> checkHack($sql)) {
    $con -> query($sql);
} else {
    header("../pages/errors/problem.php");
    }
if($errors -> checkHack($sql2)) {
    $con -> query($sql2);
} else {
    header("../pages/errors/problem.php");
    }
if($errors -> checkHack($sql3)) {
    $con -> query($sql3);
} else {
    header("../pages/errors/problem.php");
    }
//Skok zpátky na login
header("location: .././pages/login.php");
?>