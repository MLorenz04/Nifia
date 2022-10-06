<?php 
//Třída s podmínkami a checkováním určitých dat. Tady byl záblesk o pokus objektového programování.
 class Check { 

//Check, jestli se někdo nesnaží o sql injection
function checkHack($sql) {
    $sql = preg_replace('/\s+/', '', $sql); //Odebere mezery
    $sql = substr($sql, 12); //Odebere první 12 znaků -> Tím se zamezí, že metoda hodí error i když není nikde sql injection, protože sql začíná právě něčím z arraye sqlek dole
    $arrayOfSql = ["select", "update","droptable", "insertinto","truncatetable,<?php"];//Tady pole příkazů pro sql -> update, insert, drop atd... Velmi strohý pokus o vlastní zabránění sql injection.
    foreach($arrayOfSql as $item) { //Pro každý item, který by tam mohl být, 
    if(str_contains($sql,$item)) {
        return 0;
    }
}
return 1;
}
//Check, jestli email odpovídá regexu
function checkEmail($email) {
    $reg = "/^[\w\.]+@([\w-]+\.)+[\w-]{2,4}$/";
    if(preg_match($reg, $email)==false) {
        return 0;
    } else {
        return 1;
    }
    }
//Check, jestli jméno existuje a odpovídá pravidlům
function checkName($name) {
    //Tady mi nefungoval require, tak jsem šel cestou minimálního odporu
    $name="localhost";
    $username = "root";
    $password = "";
    $dbname = "nightingale";
    $con = new mysqli($name, $username, $password, $dbname);
    $sql = "select * from user where username='$name'";
    $result = $con -> query($sql);
    if(!($row = $result -> fetch_assoc())) {
$reg = "/^[a-zA-Z,á,č,é,ě,í,ň,ó,ř,š,ť,ů,ú,ý,ž]{3,20}/";
if(strlen($name) < 3 || strlen($name) > 20 ) {
    return 0;
} else if (preg_match($reg, $name)==false) {
    return 0;
} else {
    return 1;
}
}
}
//Check informací ohledně uživatele
function checkAboutMe($infoAbout) {
    $reg="/^[\w\W]{0,500}$/";
    if(preg_match($reg, $infoAbout) ) {
        return 1;
    } else {
        return 0;
    }
}
//Metoda na check slova, které se vkládá do databáze
function checkWord($word) {
    $reg = "/^[a-z,á,č,é,ě,í,ň,ó,ř,š,ť,ů,ú,ý,ž]{1,20}$/";
    if(preg_match($reg, $word)==1) {
        return 1;
    } else {
        return 0;
    }
}
//Funkce na check, jestli je číslo v určitém rozsahu
function checkNumber($number, $max, $min) {
if($number>=$min && $number<=$max) {
return 1;
} else {
    return 0;
}
}
//Check básně, jestli není moc krátká nebo moc dlouhá
function checkPoem($poem) {
    if(strlen($poem) >= 40 && strlen($poem)<=3000) {
        return 1;
    } else {
        return 0;
    }
} 
//Check nadpisu, jestli není moc krátký, či dlouhý
function checkTitle($title) {
    if(strlen($title) >= 3 && strlen($title) <= 40) {
        return 1;
    } else {
        return 0;
    }
}
//Check, jestli je uživatel přihlášen
function isLogged($username) {
    if($username == $_SESSION["username"]) {
        return 1;
    } else {
        return 0;
    }
}
//Check, jestli heslo odpovídá pravidlům
function checkPassword($password) {
    $reg = "/^[a-zA-Z,á,č,é,ě,í,ň,ó,ř,š,ť,ů,ú,ý,ž,#,&,!,?,1-9]{8,40}$/";
    if(preg_match($reg, $password)) {
        return 1;
    } else {
        return 0;
    }
}
 }
?>