<?php
//Funkce, která vytvoří cookie na error, která se vypíše při psaní, pokud nastane error.
function writeError($error) {
setcookie("error",$error,time() + 3,"/");
}
?>