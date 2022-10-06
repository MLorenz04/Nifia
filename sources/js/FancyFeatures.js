/*
Tento skript funguje jako "clean" zobrazování a reloadování. Pokud uživatel na něco klikne, tak skript změní vlastnost určitého 
elementu. Například metoda changeFollow změní obsah tlačítka ze "Sledovat" na "Sleduji" a naopak, podle toho, v jakém stavu je
Tento stav se nastavuje na začátku načtení stránky. SQL je provedeno a v databázi se zapíše, ovšem díky js nebude muset stránku
Znovu načítat, aby byla vidět změna. Jedná se jenom o tvz. fancy features.
*/
function changeFollow($name,id) {
    if($("#" +id).val()=="Sledovat!") {
        console.log("Followuju");
        $("#" +id).val("Sleduji!");
        $.ajax({
            type: "POST",
            url: "../php/giveFollow.php",
            data: {
                user: $name
            },
        });
        return;
        }
    if($("#" +id).val()=="Sleduji!") {
        console.log("Odfollowuju");
        $("#" +id).val("Sledovat!");
        $.ajax({
            type: "POST",
            url: "../php/takeBackFollow.php",
            data: {
                user: $name
            },
          });
          return;
    }
}
