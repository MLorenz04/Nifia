<!-- Require s přístupy do DB, JQuery a komponenty -->
<?php

session_start();
if(isset($_SESSION["username"]) && $_SESSION["username"]!="") {
require "../vendor/jquery.php";
require "../components/head.php";
require "../components/database.php";
require "../components/header.php";
require "../components/body.php";
require "../php/check.php";
require "../php/errorMessages.php";
require "../php/writeError.php";
$errors = new Check();
$content = "";
$title = "";
if(isset($_GET["idEdit"])){
    $idEdit = $_GET["idEdit"];
    $sqlEdit = "select * from contribution where id='$idEdit'";
    if($errors->checkHack($sqlEdit)) { 
        $result = $con -> query($sqlEdit);
        while($row = $result-> fetch_assoc() ) {
            if($row["author"] == $_SESSION["username"]) { 
$content = $row["poem_content"];
$title = $row["title"];
} else {
    unset($idEdit);
    writeError($errorNotYourContribution);
}
        }
        } else {
        header("/pages/errors/problem.php");
        }
 }

?>
<main>
    <!-- Chybové hlášky, které jsou dělané přes cookies->V tomto případě jsem je spíše chtěl zakomponovat, vím, že by to šlo udělat i přes session. -->
    <p id="errorMess" class="error">
        <?php
        if (isset($_COOKIE["error"])) {
            echo $_COOKIE["error"];
        }
        ?>
    </p>
    <!-- Samotný kontejner s formulářem -->
    <div class="writeContainer">
        <?php 
        if(!isset($idEdit)) {
        ?>
        <form action="../php/sendWrite.php" method="POST" id="formWrite" class="formWrite">
            <?php  } else { ?>
                <form action="../php/sendWrite.php?rewrite=true&idContrib=<?php echo $idEdit; ?>" method="POST" id="formWrite" class="formWrite">
            <?php
            }
                ?>
            <div class="inputarea">
                <!-- Nadpis, title -->
                <h2> Název básně </h2>
                <input type="text" name="title" class="titlePoem" value="<?php if(isset($idEdit)){echo $title;} ?>"><br>
                <!-- Select s typem básně -->
                <h2> Typ básně </h2>
                <select name="typeOfPoem" id="typeOfPoem" form="formWrite">
                    <option value="AABB">Střídavý - ABAB</option>
                    <option value="AABB">Sdružený - AABB</option>
                    <option value="ABBA">Obkročný - ABBA</option>
                    <option value="ABCB">Přerývaný - ABCB</option>
                    <option value="ABCABC">Postupový - ABC ABC</option>
                    <option value="tirad">Tirádový - AAAA</option>
                    <option value="sonet">Sonet</option>
                    <option value="other"> Ostatní </option>
                </select>
            </div>
            <br>
            <!-- Samotná báseň -->
            <textarea name="poem" id="writing" cols="30" rows="10" class="writing"><?php if(isset($idEdit)){echo $content;} ?></textarea> <br>
            <button type="submit"> Sdílet! </button>
    </div>
    </form>
    <!-- Helper, pomocníček. O něm píši více v ReadMe dokumentaci. -->
    <div class="info">
        <!-- Input pro slovo  -->
        <h2> Hledej rým! </h2>
        <input type="text" id="word" name="word"> </input> <br>
        <!-- Počet písmen od konce, ke kterým se má slovo rýmovat -->
        <h4> Počet koncových písmen </h4>
        <input type="number" id="endingNumber" name="endingNumber"></input> <br><br>
        <button id="reload"> Odeslat </button>
    </div>
    <div id="helper">
        <!-- Volání pomocníčka s rýmy  -->
        <?php
        if (isset($_GET["word"]) && isset($_GET["endingNumber"])) {
            require "../components/helper.php";
        }
        ?>
    </div>
</main>
<!-- Footer  -->
<?php
require "../components/footer.php"
?>
<!-- Skript na nestatický reload pomocníčka -->
<script src="../sources/js/helperWrite.js"></script>

<?php 
 } else {
     header("location: ./login.php");
 }
?>