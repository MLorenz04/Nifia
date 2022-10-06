<!--
Tento soubor umožňuje nahrát do databáze libovolnou e-knihu, respektive její textový převod (.txt). 
Postupně projede jednotlivá slova, která zkontroluje pomocí regulérního výrazu. 
Jakmile zjistí, že slovo není v databázi a splňuje podmínky vložení, vloží ho do ní.
Přiznám se, že vím, že se nejedná o nejrychlejší algoritmus, ale šlo mi spíše o to mít rychle 
hotovou databázi s co nejvíce českými slovy, takže než insert dat dojel, měl jsem připravenou další knihu. (Občas zabral pár desítek sekund :( )
-->
<?php
require "../components/database.php";
$errors = new Check();
$usedWords = [];
$wordsInDB = [];
require "../php/check.php";
//Vezme knízku, odebere čárky a rozloží slova od mezer.
$file = file_get_contents('../ebooks/VlcakKazan.txt');
$file = str_replace(",", "", $file);
$words = explode(" ", $file);
$len = count($words);
//sql příkazy
$sql = "insert into words";
$sql = "select word from words";
if($errors->checkHack($sql)) { 
    $result = $con -> query($sql);
    } else {
    header("../pages/errors/problem.php");
    }
//Vezme všechny slova, které jsou v db a uloží je do pole, které se kontroluje.
while ($row = $result->fetch_assoc()) {
    array_push($wordsInDB, $row["word"]);
}
?>
<main>
    <?php
    //Cyklus, kontroluje každé nové slovo se slovy v DB a pokud nenajde a splňuje regex, tak ho dá do DB
    for ($i = 0; $i < $len; $i++) {
        if ($errory -> checkWord($words[$i])) {
            if (!in_array($words[$i], $usedWords) && !in_array($words[$i], $wordsInDB)) {
                array_push($usedWords, $words[$i]);
                $sql = "insert into words(word,length) values('$words[$i]'," . strlen($words[$i]) . ");";
                if($errors->checkHack($sql)) { 
                    $result = $con -> query($sql);
                    } else {
                    header("../pages/errors/problem.php");
                    }
            }
        }
    }
    ?>
</main>