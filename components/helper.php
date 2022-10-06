<?php
include "../vendor/script.php";
include "../components/database.php";
require "../php/check.php";
$errors = new Check();
$word = $_GET["word"];
$endNumber = $_GET["endingNumber"];
$wordEnding = str_replace("'","", $word);
$wordEnding = transliterateString($wordEnding);
$wordlen = strlen($word);
$wordEnding = substr($wordEnding, (-$endNumber));
$sql = "select word from words where '$wordEnding' = RIGHT(word,$endNumber);";
if($errors->checkHack($sql)) { 
    $result = $con -> query($sql);
    } else {
    header("location: ../pages/errors/problem.php");
    }
?>
<aside class="helper">
<h2> Rýmy na slovo: <?php echo $word ?> </h2>
    <ul class="helperList" id="helperList">
       <?php  while($row = $result -> fetch_assoc()) {
   ?>
    <li class="helperSingleItem"> <a href="https://cs.wiktionary.org/wiki/<?php echo ($row['word']); ?>" ?> # <?php echo $row["word"]; ?> </a> </li>
   <?php
}
?>
    </ul>
</aside>