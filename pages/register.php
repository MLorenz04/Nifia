<!-- Require a přístup do db -->
<?php
require "../components/head.php";
require "../vendor/jquery.php";
require "../components/body.php";
require "../components/database.php";
?>
    <!-- Chybové hlášky, které jsou dělané přes cookies->V tomto případě jsem je spíše chtěl zakomponovat, vím, že by to šlo udělat i přes session. -->
    <p id="errorMess" class="error">
        <?php
        if (isset($_COOKIE["error"])) {
            echo $_COOKIE["error"];
        }
        ?>
    </p>
    
<!-- Formulář s registrací -->
<div class="centerForm"> 
<form action="../php/register/register.php" method="post">
    <label for="nickname"> Básnický pseudonym <label>
    <input type="text" name="username"> <br><br>
    <label for="password"> Heslo </label>
    <input type="password" name="password"><br><br>
    <label for="password"> Heslo znovu </label>
    <input type="password" name="passAgain"><br><br>
    <label for="email"> Emailová adresa </label>
    <input type="email" name="email"><br><br>
    <button type="submit"> Odeslat </button>
</form>
<!-- Odkaz na login -->
<p> Už zaregistrovaný? Přihlaš se! </p>
<a href="./login.php"> <b> Přihlášení </b> </a>
    </div>
<!-- Patička  -->
<?php
require "../components/footer.php";
?>