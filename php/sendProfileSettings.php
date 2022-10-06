<?php
//Requires
require "../components/database.php";
require "./errorMessages.php";
require "./check.php";
//Třída s errory
$errors = new Check();
//Začátek session
session_start();
//Proměnné
$usernameBeforeChange = $_SESSION["username"];
$username = $_POST["name"];
$infoAbout = $_POST["aboutMe"];
$email = $_POST["email"];
$gender = $_POST["gender"];
$imgContent = "";
$redirect = 0;
//Podmínka, která kontroluje, jestli je jméno a email v pořádku. Následně začne brát fotku a začne ji zpracovávat
if ($errors->checkName($username) == 1 && $errors->checkEmail($email) == 1) {
    $infoAboutFile = ($_FILES["image"]["name"]); //Vezme info o fotce
    if (!empty($infoAboutFile)) { //Pokud není prázdná, pokračuje
        $typeOfFile = pathinfo($infoAboutFile, PATHINFO_EXTENSION); //Získá její extension, koncovku, podle které zjistí, jestli je podporovaný formát a nebo ne.
        $nameOfFile = basename($_FILES["image"]["name"]);
        $typesOfImages = array('jpg', 'jpeg', 'png', "webp"); //Pole s povolenými formáty
        if (in_array($typeOfFile, $typesOfImages)) { //Pokud je extension fotky v poli, začne import
            $image = $_FILES["image"]["tmp_name"];
            $imgContent = addslashes(file_get_contents($image)); //Získá obsah fotky jako string, v db uložený jako longblob.
        }
    }
    $sql = "UPDATE user SET profilePic='$imgContent', email='$email', gender=$gender, infoAbout='$infoAbout' where username='$username'"; //sqlko
    $errors->checkHack($sql);
    //Check proti hacknutí
    if ($errors->checkHack($sql)) {
        $con->query($sql);
    } else {
    header("location: ../pages/errors/problem.php");
    $redirect ++;
    }
    if($redirect==0) {
    header("location: ../pages/profile.php?username=$username");
}
} else {
    if($redirect==0) {
    header("location: ../pages/profileSettings.php");
}
}
