<?php
//Checknutí přihlášení
session_start();
require "../php/check.php";
$errors = new Check();
$usernameUser = $_SESSION["username"];
if (isset($usernameUser)) {
    if ($errors->isLogged($usernameUser)) {
        //Databáze a Jquery
        require "../vendor/jquery.php";
        require "../components/database.php";
        //Proměnné
        $sqlId = "select id from user where username='$username'";
        //Check proti hacknutí
        if ($errors->checkHack($sqlId)) {
            $id = $con->query($sqlId);
        } else {
            header("../pages/errors/problem.php");
        }
        require "../components/head.php";
        require "../components/header.php";
        require "../components/body.php";
        //Pokus získat případné jiné jméno z url adresy -> Jelikož session by vedla jenom k přihlášenému uživateli a session na začátku slouží k rozpoznání, jestli je uživatel lognutý.
        if(isset($_GET["username"])){
            $username = $_GET["username"];
        }
        //Sql na zjištění ohledně followu
        //Follow sami o sobě ještě nejsou dělané staticky a potřebují reload, to budu předělávat asi v budoucnu -> nyní mi šlo hlavně o funkčnost.
        $sqlFollow = "select * from follows where follower='$usernameUser' AND following='$username'";
        //Check proti hacknutí
        if ($errors->checkHack($sqlFollow)) {
            $result = $con->query($sqlFollow);
        } else {
            header("../pages/errors/problem.php");
        }
        if (mysqli_num_rows($result) != 0) {
            $follow = "Sleduji!";
        } else {
            $follow = "Sledovat!";
        }
        //Sql na informace o uživateli
        $sql = "select * from user where username='$username'";

        if ($errors->checkHack($sqlFollow)) {
            $result = $con->query($sql);
        } else {
            header("../pages/errors/problem.php");
        }
        //Zjistí, jestli daný uživatel vůbec existuje, pokud ne, tak ho vypíše
        if(mysqli_num_rows($result)==0 || $result=="" || $result ==false) {
            echo "<h2 style='text-align:center'> Tento uživatel neexistuje </h2>";
        }
        //Začátek cyklu, který vypisuje informace o uživateli
        while ($row = $result->fetch_assoc()) {
?>
            <div class="profile">
                <div class="profileContent">
                    <div class="username pink">
                        <!-- Uživatelské jméno -->
                        <h1 class="profileUsername"> -- <?php echo $row["username"]; ?> --</h1>
                        <?php
                        if ($row["username"] != $_SESSION["username"]) {
                            $username = $row["username"]
                        ?>
                            <!-- Follow tlačítka, podle stavu -->
                            <?php if ($follow == "Sledovat!") { ?>
                                <input type="button" id="follow" value="<?php echo $follow ?>" onclick="changeFollow('<?php echo $username ?>', this.id)">
                            <?php } else { ?>
                                <input type="button" id="follow" value="<?php echo $follow ?>" onclick="changeFollow('<?php echo $username ?>', this.id)">
                        <?php
                            }
                        }
                        ?>
                        <!-- Nastavení a odhlášení -->
                        <div class="profileSettingCenter marginTopSettings">
                            <?php  if($usernameUser==$username) { ?>
                            <a href="/Nightingale/pages/profileSettings.php" class="profileSetting pink"> Nastavení </p> </a>
                            <a href="/Nightingale/php/disconnect.php" class="profileSetting pink"> Odhlásit </p> </a>
                            <a href="/Nightingale/pages/collections.php" class="profileSetting pink"> Vytvořit sbírku </p> </a>
                            <a href="/Nightingale/pages/editCollection.php" class="profileSetting pink"> Editovat sbírky </p> </a>
                       <?php }?>
                            </div>
                    </div>
                    <!-- Profilová fotka -->
                    <div class="imageContainer">
                        <?php if ($row["profilePic"] != "") { ?>
                            <img id="profilePic" src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row["profilePic"]) ?>" />
                        <?php
                        } else {
                        ?>
                            <img id="profilePic" src="https://www.business2community.com/wp-content/uploads/2017/08/blank-profile-picture-973460_640.png">
                        <?php } ?>
                    </div>
                    <div class="userContent">
                        <?php
                        $username = $row["username"];
                        $sqlSelectPost = "SELECT * FROM contribution where author='$username'";
                        //Check proti hacknutí
                        if ($errors->checkHack($sqlSelectPost)) {
                            $result2 = $con->query($sqlSelectPost);
                        } else {
                            header("../pages/errors/problem.php");
                        }
                        if ($result2 != false) {
                            while ($row2 = $result2->fetch_assoc()) { ?>
                                <div class="contributionContainerProfile">
                                    <!-- Nadpis básně -->
                                    <h2 class="title"><?php echo $row2["title"] ?></h2>
                                    <div class="contributionContent">
                                        <!-- Content básně -->
                                        <pre><?php echo nl2br($row2["poem_content"]); ?></pre>
                                    </div>
                                    <hr class="dividerInfo">
                                    <!-- Autor -->
                                    <div class="author">
                                        <?php echo $row2["author"]; ?>
                                    </div>
                                    <!-- Datum -->
                                    <div class="date">
                                        <?php echo $row2["date"]; ?>
                                    </div>
                                    <div class="edit">
                                        <?php
                                        if ($row2["author"] == $username) {
                                            $idOfCont = $row2["id"]
                                            ?>
                                            <a href="../pages/write.php?idEdit=<?php echo $idOfCont; ?>"> Editovat </a>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                        <?php }
                        }
                        ?>
                    </div>
                </div>
                <!-- Container s informacemi -->
                <div class="profileAside">
                    <h3 style="text-align:center"> Informace </h3>
                    <!-- Počet básní  -->
                    <div id="PoetryCount" class="profileInfo">
                        <p> Počet básní: <span class="profileCountInfo"> <?php echo $row["PoetryCount"]; ?> </span> </p>
                    </div>
                    <!-- Počet followers -->
                    <div id="followCount" class="profileInfo">
                        <p> Počet sledování: <span class="profileCountInfo"> <?php echo $row["followCount"]; ?> </span> </p>
                    </div>
                    <div id="infoAbout">
                        <!-- Info ohledně profilu -->
                        <p class="profileInfo"> <?php
                                                if ($row["infoAbout"] != "") {
                                                    echo $row["infoAbout"];
                                                } else {
                                                    echo "Ahoj, vítej na mém profilu!";
                                                }
                                                ?>
                    </div>
                    <!-- Začátek sbírek -->
                    <div class="poemsCollection">
                        <h3> Sbírky </h3>
                        <?php
                        $sql = "select name from collections where author='$username'";
                        $result = $con->query($sql);
                        while ($row = $result->fetch_assoc()) {
                        ?>
                            <a href="../pages/singleCollection.php?title=<?php echo $row['name'] ?>"><?php echo $row['name'] ?> </a>
                        <?php
                        }
                        ?>
                    </div>
                </div>
    <?php
        }
        //Footer
        require "../components/footer.php";
    } else {
        header("location: ./login.php");
    }
} else {
    header("location: ./login.php");
}
    ?>
    <!-- Skript na fancy features -->
    <script src="../sources/js/FancyFeatures.js"> </script>