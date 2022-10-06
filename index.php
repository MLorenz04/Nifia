
<!-- Celá hlavní stránka, postavená pouze z komponentů -->
<?php
session_start();
if(isset($_SESSION["username"]) && $_SESSION["username"]!="") {
require "./components/database.php";
require "./components/head.php";
require "./vendor/jquery.php";
// Začátek těla
require "./components/body.php";
require "./components/header.php"; 
require "./components/aside.php";
?>
<p id="errorMess" class="error"> </p>

<?php
require "./components/contents.php";
require "./components/footer.php";
} else {
    header("location: pages/login.php");
}
?>
