Zdravím! 

Zde odevzdávám závěrečný projekt na PV. Jedná se o skromnou sociální síť na poezii Nightingale.

Instalace:

Vložte tento projekt do složky htdocs v programu XAMPP.
Otevřete phpmyadmin na localhostu, vytvořte si databázi "nightingale" a exportněte do ni přiložený soubor "nightingale.sql"
Otevřete novou stránku localhost/Nightingale a užívejte!

Sociální síť jako taková je stavěná na menší počet básní a uživatelů. Nemám zatím nastavené indexy, jakékoliv získávání dat je vlastně prohledávání všech dat bez nějakého složitějšího algoritmu. Dost věcí jsem se také snažil napsat sám, jako například metody na sqj injection, kontrolu pomocí regexů. I přesto využívám dost PHP metod, které k tomu jsou určené.

I přesto ale funguje, normálnímu uživateli by se nemělo podařit síť shodit a snad všechny vstupy jsou ošetřeny. 




Poznámky ohledně kritérií hodnocení:

Configurability and universality
- Uživatel má možnost změny jména, emailové adresa, informací ohledně něj, pohlaví, profilovou fotku. 
- Samotná sociální síť jako taková pořádné nastavení nemá.

Architecture and design patterns
- Přiznám se, že objektové programování mi nikdy nešlo do ruky, takže celá sociální síť je vlastně skládaná z komponent
- Komponenty zabraňují hlavně duplicitě kódu a pomáhají pomocí šesti řádků postavit celou stránku, na které se pak dostaví určité potřebné věci.

Usability and program control.
- User interface je podle mě celkem zvládnutý, nejsou nikde poschovávané tlačítka, ale přiznám se, že cssko, vzhledem k tomu, že nebylo počítané, mě nutilo i kvůli času neřešit media queries a obecný pořádný layout stránky. 

Correctness and efficiency 
- To, co má dělat, dělá. Uživatel může sledovat, psát básně, sbírky, dokonce funguje i pomocník na rýmy. Vrací se případně i errory, takže působení na stránce není zmatečné.

Testing and error handling
- Tohle si myslím, že jsem zvládl celkem v pohodě. Jakékoliv vstupy jsou ošetřeny pomocí regexů a spoustou podmínek, navíc by měla fungovat i částečná ochrana proti sql injection, kterou jsem si napsal sám.
- Během testování jsem nenašel asi nic, co by program shodilo (Možná se to ale vám povede)

Documentation and code readability
- Všechen kód je formátovaný podle extension Prettier. 
- Snad každá část kódu je zakomentovaná, aby bylo jasné, oč se jedná. 
