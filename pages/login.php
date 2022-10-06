<!-- Začátek stránky, dva require na tělo stránky a databázi -->
<?php
session_start();
require "../components/head.php";
require "../components/body.php";
require "../vendor/jquery.php";
require "../components/database.php";
?>
<!-- Jednoduchý formulář s přihlášením  -->
    <!-- Chybové hlášky, které jsou dělané přes cookies->V tomto případě jsem je spíše chtěl zakomponovat, vím, že by to šlo udělat i přes session. -->
    <p id="errorMess" class="error">
        <?php
        if (isset($_COOKIE["error"])) {
            echo $_COOKIE["error"];
        }
        ?>
    </p>
    <div class="centerForm"> 
<form action="../php/login/login.php" method="post">
    <label for="nickname"> Básnický pseudonym <label>
    <input type="text" name="username"> <br><br>
    <label for="password"> Heslo </label>
    <input type="password" name="password">
    <br><br>
    <button type="submit"> Přihlásit </button>
</form>
<!-- Odkaz na registraci -->
<p> Ještě nemáš účet? Zaregistruj se! </p>
<a href="./register.php"> <b>Registrace</b> </a>
</div>
<!-- Footer -->
<?php
require "../components/footer.php";
?>