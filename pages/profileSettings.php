
<?php
//Checkování, jestli je uživatel lognutý
session_start();
require "../components/database.php";
require "../php/check.php";
$errors = new Check();
$username = $_SESSION["username"];
if(isset($_SESSION["username"])) {
    if($_SESSION["username"]!="") {
//Requires a začátek stránky
require "../components/head.php";
require "../vendor/jquery.php";
require "../components/header.php";
require "../components/body.php";
//Proměnné
$sql = "select * from user where username='$username';";
//Start sql, které získá informace a uloží do proměnných
if($errors->checkHack($sql)) { 
    $result = $con -> query($sql);
    } else {
    header("./errors/problem.php");
    }
while ($row = $result->fetch_assoc()) {
    $username = $row["username"];
    $info = $row["infoAbout"];
    $email = $row["email"];
    $gender = $row["gender"];
}
?>
<div class="profileFormContainer">
    <div class="profileForm">
        <form id="settings" action="../php/sendProfileSettings.php" class="profileSettings" method="post" enctype="multipart/form-data">
            <!-- Jméno -->
            <label for="nameForm"> Jméno </label>
            <input type="text" maxlength="20" name="name" id="nameForm" value="<?php echo $username ?>"> <br> <br>
            <!-- Email -->
            <label for="emailForm"> Emailová adresa </label>
            <input type="text" name="email" id="emailForm" value="<?php echo $email ?>"> <br> <br>
            <!-- Informace o mě -->
            <label for="aboutMe"> O mně </label>
            <textarea maxlength="400" class="textareaAboutMe" id="aboutMe" name="aboutMe"><?php echo $info ?></textarea> <br> <br>
            <!-- Select s pohlavím  -->
            <label for="gender"> Pohlaví </label> <br>
            <select class="gender" name="gender" id="gender">
                <option value="1" <?php if ($gender == 1) {
                                        echo "selected";
                                    } ?>> Muž </option>
                <option value="2" <?php if ($gender == 2) {
                                        echo "selected";
                                    } ?>> Žena </option>
                <option value="3" <?php if ($gender == 3) {
                                        echo "selected";
                                    } ?>> Jiné </option>
                <option value="4" <?php if ($gender == 4) {
                                        echo "selected";
                                    } ?>> Neurčeno </option>
            </select><br> <br>
            <!-- Profilová fotka -->
            <label for="name"> Profilová fotka </label>
            <input type="file" name="image">
            <!-- Send button -->
            <button id="send"> Odeslat </button>
        </form>
        <div class="profileFormContainer">
    <div class="profileForm">
        <a href="../php/destroyProfile.php"> Smazat účet </a>
    </div>
    </div>
    </div>
</div>
<!-- Footer -->
<?php
require "../components/footer.php";
} 
} else {
    header("location: ./login.php");
}
?>