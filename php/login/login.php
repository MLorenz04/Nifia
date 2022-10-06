<!-- Require s databází -->
<?php 
require "../../components/database.php";
require "../../php/errorMessages.php";
require "../writeError.php";
require "../check.php";
$errors = new Check();
//Proměnné
$nickname = $_POST["username"];
$password = $_POST["password"];
$result = "";
//Sql příkaz
$sql = "select username, password from user where username='$nickname'";
//Check před sql injection
if($errors->checkHack($sql)) { 
$result = $con -> query($sql);

if(mysqli_num_rows($result) > 0) {
while($row = $result -> fetch_assoc()) {
    $hashedPassword = $row["password"];
}
if(!(password_verify($password,$hashedPassword))) {
    header("location: ../../pages/login.php");
    writeError($errorBadPassword);
} else {
    //Započetí session s loginem a odkázání na index
    session_start();
    $_SESSION["login"] = 1;
    $_SESSION["username"] = $nickname;
   header("location: ../../index.php");
}
} else {
    header("location: ../../pages/login.php");
    writeError($errorNonExistenceUsername);
}
} else {
    header("location: ../../pages/errors/problem.php");
}
?>