<div class="homepageContainer"> 
<div class="homepage">
<?php
if (isset($_COOKIE["error"])) {
    echo $_COOKIE["error"];
}
?>
</p>
<?php
//Require databáze
require "components/database.php";
require "php/check.php";
$errors = new Check();
$youFollowNobody = false; //Check, jestli uživatel sleduje alespoň jednoho autora
$name = $_SESSION["username"];
//Začátek zjišťování, koho uživatel sleduje a jaké příspěvky má vypsat
$sqlWhoDoYouFollow = "select following from follows where follower='$name'";
$sql = "select * from contribution where author IN ("; //začátek sql, do kterého se budou připisovat autoři, které sleduje uživatel
if($errors->checkHack($sqlWhoDoYouFollow)) { 
$followers = $con -> query($sqlWhoDoYouFollow);
} else {
header("location: ../pages/errors/problem.php");
}
$followerList = array();
//Pole se sledujícími
while ($row = $followers -> fetch_assoc()) {
array_push($followerList, $row["following"]);
}
//Pokud jenom jeden sledující
if(count($followerList) == 1) {
    foreach($followerList as $value) {
      $sql .= "'$value'";
    };
    }
//Více sledujících
    if(count($followerList) > 1){
      foreach($followerList as $value) {
        $sql .= "'$value',";
      };
      $sql = substr($sql, 0, -1); //Odebrání čárky
    }
    $sql .= ") ORDER BY date desc;"; //Konec závěrečného sql

    ///Pokud ani jeden sledující
if(count($followerList) == 0 || null) {
    $youFollowNobody = true;
}
if(!$youFollowNobody) {
    if($errors->checkHack($sql)) { 
        $result = $con -> query($sql);
        } else {
        header("../pages/errors/problem.php");
        }
    }
if($result!=false) { 
if(mysqli_num_rows($result) > 0) {
    //Cyklus na vypisování příspěvků
while ($row = $result->fetch_assoc()) {
?>
    <div class="contribution" id="<?php echo $row['id'] ?>">
    <div class="contributionContainer"> 
        <h1 class="title"><?php echo $row["title"] ?></h1>
        <div class="contributionContent">
            <pre><?php echo nl2br($row["poem_content"]); ?></pre>
        </div>
        <hr class="dividerInfo">
        <div class="author">
            <?php echo $row["author"]; ?>
        </div>
        <div class="date">
            <?php echo $row["date"]; ?>
        </div>
        <div class="edit">
            <?php
            if($row["author"]==$username) { ?>
            <a href="../pages/editContribution.php"> Editovat </a>
            <?php
            }
            ?>
        </div>
</div>
    </div>
<?php
}
} else {
    echo "Nikdo, koho sleduješ, ještě nevydal žádný příspěvek :/ Buď první!";
}
} else {
    echo "Nikoho nesleduješ!";
}
?>
 </div>
 </div>