<?php
    require "ConnDb.php";

    if (isset($_POST['zoekInput'])) {
        $zoekwaarde = $_POST['zoekInput'];
    }
    
    if (isset($_POST['vanPrijsInput'])) {
        $vanPrijs = $_POST['vanPrijsInput'];
    }
    
    if (isset($_POST['totPrijsInput'])) {
        $totPrijs = $_POST['totPrijsInput'];
    }
    
    if (isset($_POST['categorieënInput'])) {
        $categorie = $_POST['categorieënInput'];
    }
    
    $conditions = [];

    if(!empty($zoekwaarde)){
        if(is_numeric($zoekwaarde)){
            $conditions['naam'] = "advertentie.idadvertentie = $zoekwaarde";
        } else{
            $conditions['naam'] = "advertentie.naam LIKE '%$zoekwaarde%'";
        }

    }

    if(!empty($vanPrijs)){
        $conditions['vanPrijs'] = "advertentie.prijs >= '$vanPrijs'";
    }

    if(!empty($totPrijs)){
        $conditions['totPrijs'] = "advertentie.prijs <= '$totPrijs'";
    }

    if(!empty($categorie) && $categorie != "0"){
        $conditions['categorie'] = "advertentieCategorieën.idcategorie =$categorie ";
    }
    $everyCondition = implode(' AND ', $conditions);
    if($everyCondition != ""){
        $everyCondition = "AND ". $everyCondition;
    }

    $stmt = $conn->prepare("SELECT advertentie.idadvertentie as id, 
       advertentie.Naam as naam, 
       advertentie.prijs as prijs, 
       afbeeldingen.afbeeldinglocatie as locatie,
       afbeeldingen.order as orderimage,
       gebruiker.logolocatie as logolocatie,
       advertentieCategorieën.idcategorie as idcategorie
FROM advertentie
INNER JOIN afbeeldingen USING(idadvertentie)
INNER JOIN gebruiker USING(idgebruiker)
INNER JOIN advertentieCategorieën USING(idadvertentie)
WHERE afbeeldingen.order = 1 ". $everyCondition . "
GROUP BY advertentie.idadvertentie"
                            );
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            $afbeeldingLocatie = $row['logolocatie'];
            $advertentieNaam = $row['naam'];

if (strlen($advertentieNaam) > 18) {
    $advertentieNaam = substr($advertentieNaam, 0, 18) . '...';
}

            echo "<div class='advertentie' advertentieId=".$row['id'].">";
                echo "<img class='advertentieImg'src='afbeeldingenUsers/" . $row['locatie'] . "'>";
                echo "<div class='advertentieinfo'>";
                    echo "<img src='afbeeldingenUsers/profielicons/".$afbeeldingLocatie."' class='bedrijfslogo'>";
                    echo "<p>" . $advertentieNaam . "</p>";
                    echo "<p class='prijs'>" ."€ ". str_replace(".",",",''.$row['prijs'].'') . "</p>";
                echo "</div>";
            echo "</div>";
        
        }
    } else{
        echo "geen resultaten gevonden";
    }

?>
