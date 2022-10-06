<?php
//začátek session a requires
session_start();
require "../components/database.php";
$username = $_SESSION["username"];
require "../php/check.php";
require "../php/errorMessages.php";
require "../php/writeError.php";
$errors = new Check();
$poems = $_POST["poems"]; //Idčka všech básní
$title = $_POST["title"]; //Nadpis sbírky
$atLeastOnePoem = 0;//Kontrola, že ve sbírce je alespoň jedna báseň
$titleExists = false;
//Pokud je oboje nastaveno a není prázdný
if (isset($title) && isset($poems)) {
    if ($title != "" && $poems != "") {
        //Zjistí, jestli už neeexistuje sbírka se stejným jménem
        $sqlTitles = "select name from collections";
        $result = $con->query($sqlTitles);
        while ($row = $result->fetch_assoc()) {
            if ($title == $row["name"]) {
                $titleExists = true;
            }
        }
        if($titleExists == false) {
        //Vezme každé idčko v poli básní
        foreach ($poems as $poem) {
            $sql = "select * from poemsincontribution where idContribution=$poem"; //Zjistí, jestli báseň náhodou už není v nějaké sbírce.
            if ($errors->checkHack($sql)) {
                $result = $con->query($sql);
            } else {
                header("location: ../pages/errors/problem.php");
            }
            if ($result == false || mysqli_num_rows($result) == 0) {
                //Vloží báseň do pole básní ve sbírkách
                $sql2 = "insert into poemsincontribution(author,idContribution, Collection) values('$username','$poem','$title')";
                $atLeastOnePoem+=1;
                if ($errors->checkHack($sql)) {
                    $result = $con->query($sql2);
                } else {
                    header("location: ../pages/errors/problem.php");
                }
            } 
        }
        if($atLeastOnePoem>0) { 
            //Pokud si vybral alespoň jednu správnou báseň, vloží ji do DB
        $sql3 = "insert into collections(name,author) values('$title','$username')";
        echo $sql3;
        if ($errors->checkHack($sql)) {
            $con->query($sql3);
        } else {
            header("location: ../pages/errors/problem.php");
        }
        //A tady je už jenom spoustu headerů a error messages
        header("location: ../pages/singleCollection.php?title=$title");
    } else {
        writeError($errorNoFreePoem);
        header("location: ../pages/collections.php");
    }
    } else {
        writeError($errorCollectionExists);
header("location: ../pages/collections.php");
    }
} else {
    writeError($errorNoTitle);
    header("location: ../pages/collections.php");
}
} else {
    writeError($errorNoPoem);
    header("location: ../pages/collections.php");
}
