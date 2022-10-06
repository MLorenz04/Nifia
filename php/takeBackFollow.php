<?php //Základní requires s údaji do db, checkem errorů
require "../components/database.php";
require "../php/check.php";
session_start();
$username = $_SESSION["username"];
$usernameUser = $_POST["user"];
//Třída s checkováním
$errors = new Check();
//sql s příkazem, který odebere údaj o followu
$sqlGiveFollow = "delete from follows where follower='$username' and following='$usernameUser'";
//sql odebere záznam o followu
$sqlAddInfo = "update user set followCount = followCount-1 where username='$usernameUser'";
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