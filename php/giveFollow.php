<?php
//Základní requires s údaji do db, checkem errorů
require "../components/database.php";
require "../php/check.php";
session_start();
$errors = new Check();
$username = $_SESSION["username"];
$usernameUser = $_POST["user"];
//sql s příkazem, který vloží údaj o followu
$sqlGiveFollow = "insert into follows(follower, following) values('$username','$usernameUser')";
$sqlAddInfo = "update user set followCount = followCount+1 where username='$usernameUser'";
//Updatne uživatele, aby měl ve statistikách počet follows.
if($errors -> checkHack($sqlAddInfo)) {
    $con -> query($sqlAddInfo);
} else {
    echo "Chyba!";
    }
//Check proti hacknutí, nastaví follow
if($errors -> checkHack($sqlGiveFollow)) {
    $con -> query($sqlGiveFollow);
} else {
    echo "Chyba!";
    }
?>