<?php
// Základní requires
require "../components/database.php";
require "../php/check.php";
require "../php/errorMessages.php";
require "../vendor/jquery.php";
//Metoda na zavolání třídy na check
$errors = new Check();
//Session s jménem
session_start();
$idCollection = $_GET["id"];
$username = $_SESSION["username"];
if (isset($username)) {
    //Vybere určitou sbírku, pokud je uživatele, tak ji smaže
    $sql = "select * from collections where id=$idCollection";
    //Checky proti hacknutí
    if ($errors->checkHack($sql)) {
        while ($row = $con->query($sql)->fetch_assoc()) {
            if ($row["author"] == $username) {
                $sql2 = "delete from collections where id=$idCollection";
                //Checky proti hacknutí
                if ($errors->checkHack($sql2)) {
                    $con->query($sql2);
                    $nameOfCollection = $row["name"];
                    //Odebere všechny básně
                    $sql3 = "delete * from poemsincontribution where Collection='$nameOfCollection'";
                    if ($errors->checkHack($sql3)) {
                        $con->query($sql3);
                        //Spousty headerů a errory
                    } else {
                        header("location: ../pages/errors/problem.php");
                    }
                    header("location: ../pages/editCollection.php");
                } else {
                    header("location: ../pages/errors/problem.php");
                }
            } else {
                writeError($errorNotYourCollection);
                header("location: ../pages/editCollection.php");
            }
        }
    } else {
        header("location: ../pages/errors/problem.php");
    }
}
