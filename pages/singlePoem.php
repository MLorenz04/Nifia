<!-- Stránka, která vrací náhodou báseň, postavená z komponentů -->
<?php
session_start();
// Check přihlášení
if (isset($_SESSION["username"]) && $_SESSION["username"] != "") {
    require "../components/head.php";
    require "../vendor/jquery.php";
    // Začátek těla
    require "../components/body.php";
    require "../components/header.php";
    require "../php/loadNewPoem.php";
    require "../components/footer.php";
} else {
    header("location: ./pages/login.php");
}
?>
<script src="../sources/js/main.js"> </script>