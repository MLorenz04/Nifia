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
    require "../components/head.php";
    require "../components/header.php";
    require "../components/body.php";

?>
<h3 style="text-align:center"> Vítej! Zde si můžeš vytvořit sbírku svých úžasných básní. </h3>
<?php
//Errory
        if (isset($_COOKIE["error"])) {
            echo $_COOKIE["error"];
        }
        ?>
<!-- Formulář -->
<form action="../php/sendNewCollection.php" method="POST">
    <label for="title"> Název sbírky </labe>
    <input type="text" name="title">
<table>
<?php
//Sqlko, které vybere všechny básně uživatele a zobrazí je v tabulce
$sql = "select * from contribution where author='$username'";
$result = $con-> query($sql);
while($row = $result -> fetch_assoc()) { ?>
<tr>
<td> <?php echo $row["author"]; ?></td>
<td> <?php echo $row["title"]; ?></td>
<td> <input type="checkbox" name="poems[]" value="<?php echo $row["id"]; ?>">
</tr>
<?php    
}
?>
 </table>
 <button type="submit"> Vytvořit! </button>
 </form>
<?php 
require "../components/footer.php";
} else {
    header("location: ./login.php");
}
?>