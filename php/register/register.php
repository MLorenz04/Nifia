<?php
//Require potřebných proměnných a objektů
require "../../components/database.php";
require "../check.php";
require "../errorMessages.php";
require "../writeError.php";
//Třída s errory
$errors = new Check();
//Proměnné z formuláře
$goodIdea = 0;
$nickname = $_POST["username"];
$password = $_POST["password"];
$passwordAgain = $_POST["passAgain"];
$email = $_POST["email"];
$sqlCheckIfExists = "select username from user where username='$nickname'";
$result = "";
if ($errors->checkHack($sqlCheckIfExists)) {
    $result = $con->query($sqlCheckIfExists);
    if ($result != false) {
        if (mysqli_num_rows($result) == 0) {
            //Check jména
            if ($errors->checkName($nickname)) {
                $goodIdea += 1;
            } else {
                writeError($errorBadUsername);
            }
            //Check emailu
            if ($errors->checkEmail($email)) {
                $goodIdea += 1;
            } else {
                writeError($errorEmailAdress);
            }
            //Check hesla
            if ($password == $passwordAgain) {
                if($errors->checkPassword($password)) { 
                $goodIdea += 1;
                if ($goodIdea == 3) {
                    $password = password_hash($password, PASSWORD_DEFAULT);
                    //Sql na insert dat při registraci
                    $sql = "insert into user(username, password, email, gender, PoetryCount,likeCount,followCount,infoAbout,profilePic) values('$nickname', '$password','$email',0,0,0,0,'','')";

                    if ($errors->checkHack($sql)) {
                        $result = $con->query($sql);
                    } else {
                        header("location: ../../pages/errors/problem.php");
                    }
                    header("location: ../../");
                }
            } else {
                writeError($errorBadPassword);
                header("location: ../../pages/register.php");
            }
            } else {
                writeError($errorNotMatchingPassword);
                header("location: ../../pages/register.php");
            }
        }
    }   
} else {
    header("location: ../../pages/errors/problem.php");
}
