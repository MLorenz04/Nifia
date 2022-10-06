<?php
//Obyčejný soubor s redirectem
$id = $_GET["id"];
session_start();
$username = $_SESSION["username"];
if ($id == 1) {
    header("location: /Nightingale");
}
if ($id == 2) {
    header("location: /Nightingale/pages/write.php");
}
if ($id == 3) {
    header("location: /Nightingale/pages/profile.php?username=$username");
}
if ($id == 4) {
    header("location: /Nightingale/pages/singlePoem.php");
}
?>