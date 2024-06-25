<?php
require "ConnDb.php";
print_r($_POST);

        $sql1 = "INSERT INTO advertentie (naam, prijs,biedenvanaf,automatischeverwijdering, beschrijving";
        $sql2 = "INSERT INTO afbeeldingen (advertentie_idadvertentie, afbeeldinglocatie)";
        $sql3 = "INSERT INTO categorieën-advertentie (advertentie_idadvertentie, categorie_idcategorie)";
        echo "Yeaaaaa";
    
?>
