<?php
//Requires s potřebnými daty a objekty
require "../components/database.php";
require "../php/check.php";
require "../php/errorMessages.php";
require "../php/writeError.php";
//Volání třídy kontrol
$errors = new Check();
//Proměnné a session
session_start();
$username = $_SESSION["username"];
$poem = $_POST["poem"];
$title = $_POST["title"];
$typeOfPoem = $_POST["typeOfPoem"];
$rewrite = false;
//Rewrite a idContrib jsou údaje z url adresy, ty indikují, jestli se píše a nebo upravuje a případně jaký příspěvek
if(isset($_GET["rewrite"])) { 
$rewrite = $_GET["rewrite"];
}
if(isset($_GET["idContrib"])) { 
$idContrib = $_GET["idContrib"];
}
$itsOkay = true;
$date = date('Y/d/m', time());
$headerController = 0;
//"Pár" podmínek pro vypsání správné chybné hlášky
if (!$errors->checkPoem($poem)) {
    writeError($errorTooShort);
}
if (!$errors->checkTitle($title)) {
    writeError($errorTitle);
}
if (!$errors->checkPoem($poem) && !$errors->checkTitle($title)) {
    writeError($errorTitleAndPoem);
}
//A pokud je vše správně, tak se provede sql příkaz, který vloží báseň a autorovi připíše k počtu básní jedničku.
if ($errors->checkPoem($poem) && $errors->checkTitle($title)) {
    if($rewrite!=true) { 
    $sql = "insert into contribution(title,poem_content, author, date, typeOfPoem) values('$title','$poem','$username','$date','$typeOfPoem');";
    $sql2 = "update user set PoetryCount = PoetryCount + 1 where username='$username'";
    if ($errors->checkHack($sql)) {
        $con->query($sql);
        $headerController++; //Občas byl problém s headery, tak jsem musel ušetřit přes proměnné
    } else {
        header("location: ../pages/errors/problem.php");
    }
    if ($errors->checkHack($sql2)) {
        $con->query($sql2);
        $headerController++;
    } else {
        header("location: ../pages/errors/problem.php");
    }
    if($headerController==2) { 
    header("location: ../");
}
} else {
    //Rewrite znamená, že uživatel edituje příspěvek. Může editovat pouze jeho, cizí ho odkáže do háje.
    $sql = "select * from contribution where id='$idContrib'";
    if($errors->checkHack($sql)) {
        $result = $con->query($sql);
        while($row = $result -> fetch_assoc()) { 
            if($row["author"] == $username) { 
        $sql2 = "update contribution set title='$title', poem_content = '$poem', typeOfPoem = '$typeOfPoem' where id='$idContrib'";
        if($errors->checkHack($sql2)) {
            $con->query($sql2);
        } else {
            header("location: ../pages/errors/problem.php");
        }
        header("location: ../pages/profile.php?username=$username");
    } else {
        writeError($errorNotYourContribution);
        
    }
    }
    } else {
        header("location: ../pages/errors/problem.php");
    }
}
} else {
    header("location: ../");
    writeError($errorBadEdit);
}
