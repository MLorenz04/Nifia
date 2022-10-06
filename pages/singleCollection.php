<?php
session_start();
// Check přihlášení
$username = $_SESSION["username"];
if (isset($_SESSION["username"]) && $_SESSION["username"] != "") {
    require "../php/check.php";
    $errors = new Check();
    require "../components/database.php";
    require "../components/head.php";
    require "../vendor/jquery.php";
    // Začátek těla
    require "../components/body.php";
    require "../components/header.php";
    $collection = $_GET["title"];
    //Zjistí id kolekce.
    $sql = "select id from collections where name='$collection'";
    if($errors->checkHack($sql)) { 
        $resultCheck = $con -> query($sql);
        } else {
        header("../pages/errors/problem.php");
        }
        if(mysqli_num_rows($resultCheck) !=0) { 
?>
<!-- Nadpis básně -->
       <h1> Sbírka: <?php echo $collection ?> </h1>
        
    <?php
    // Začátek cyklů, které nejdříve zjistí, které básně jsou již ve sbírce. Poté je do sbírky přidá.
    $sql = "select idContribution from poemsincontribution where Collection='$collection'";
    if ($errors->checkHack($sql)) {
        $result = $con->query($sql);
        while ($row = $result->fetch_assoc()) { 
            $id = $row["idContribution"];
            $sql2 = "select * from contribution where id=$id";
        $result2 = $con->query($sql2);
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
            </div>
<?php }
}
    } else {
        header("../pages/errors/problem.php");
    }
} else {
    ?>
    <div style="width:100%">
    <h1 style="text-align:center;"> Tato sbírka neexistuje! </h1>
    <div style="width:100%; display:flex; justify-content:center;"> 
    <a href="../"> Domů </a>
    </div>
    </div>
     <?php
}
}
else {
    header("location: ./pages/login.php");
}
require "../components/footer.php";
?>