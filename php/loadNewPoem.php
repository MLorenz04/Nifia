<?php
require "../components/database.php";
require "../php/check.php";
$errors = new Check();
$sql = "select * from contribution order by rand() limit 1";
if($errors->checkHack($sql)) { 
$result = $con->query($sql);
} else {
    header("location: ../pages/errors/problem.php");
}
while ($row = $result->fetch_assoc()) {
?>
    <div id="singlePoem" class="containerAroundNewPoem">
        <div class="contributionContainerProfile">
            <!-- Nadpis básně -->
            <h2 class="title"><?php echo $row["title"] ?></h2>
            <div class="contributionContent">
                <!-- Content básně -->
                <pre><?php echo nl2br($row["poem_content"]); ?></pre>
            </div>
            <hr class="dividerInfo">
            <!-- Autor -->
            <div class="author">
                <?php echo $row["author"]; ?>
            </div>
            <!-- Datum -->
            <div class="date">
                <?php echo $row["date"]; ?>
            </div>
        </div>
        <div class="center">
            <input type="button" class="center" onclick="callNewPoem()" value="Nová báseň!">
        </div>
    </div>
<?php
}
