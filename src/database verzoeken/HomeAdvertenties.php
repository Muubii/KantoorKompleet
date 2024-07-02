<?php
    session_start();
    require "ConnDb.php";

    // Prepare SQL statement
    $stmt = $conn->prepare("SELECT advertentie.idadvertentie as id, advertentie.Naam as naam, advertentie.prijs as prijs, afbeeldingen.afbeeldinglocatie as locatie,
                            afbeeldingen.order as orderimage
                            FROM advertentie
                            INNER JOIN afbeeldingen on advertentie.idadvertentie = afbeeldingen.idadvertentie
							WHERE afbeeldingen.order = 1;
                            ");
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows > 0){
        $verborgenWaarde = 0;
        while($row = $result->fetch_assoc()){
            echo "<div class='advertentie' advertentieId=".$row['id'].">";
                echo "<img class='advertentieImg'src='afbeeldingenUsers/" . $row['locatie'] . "'>";
                echo "<h4>" . $row['naam'] . "</h4>";
                echo "<p class='prijs'>" ."€ ". str_replace(".",",",''.$row['prijs'].'') . "</p>";
            echo "</div>";
        
        }
    } else{
        echo "geen resultaten gevonden";
    }

?>
