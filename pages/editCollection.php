<?php
// Základní requires
require "../components/database.php";
require "../php/check.php";
require "../php/errorMessages.php";
require "../vendor/jquery.php";
//Metoda na zavolání třídy na check
$errors = new Check();
//Session s jménem
session_start();
$username = $_SESSION["username"];
if(isset($username)){
    //Requiry k tělu stránky
    require "../components/head.php";
    require "../components/header.php";
    require "../components/body.php";
    ?> 
    <table class="droptable">
    <?php
    //Vybere všechny sbírky a umožní autorovi je odebrat
    $sql = "select * from collections where author='$username'";
    $result = $con->query($sql);
    while($row = $result -> fetch_assoc()) { ?>
    <tr> 
    <td class="tableItem">Název sbírky: <?php echo $row["name"]; ?> </td>
    <td class="tableItem">Autor: <?php echo $row["author"]; ?> </td>
    <td class="tableItem"> <a href="../php/deleteCollection.php?id=<?php echo $row["id"]?>"> Odebrat? </a> </td>
    </tr>  
    <?php }
?>
</table>
<?php }
require "../components/footer.php" ?>
