<?php
    session_start();
    require "ConnDb.php";

    if(isset($_POST['advertentieid']) && !empty($_POST['advertentieid'])){
        $idadvertentie = $_POST['advertentieid'];

        $stmt = $conn->prepare("SELECT biedingen.idadvertentie, biedingen.prijs, biedingen.idGebruiker, gebruiker.Bedrijfsnaam, gebruiker.logolocatie
                                FROM biedingen
                                INNER JOIN gebruiker
                                USING (idGebruiker)
                                WHERE idadvertentie = ?
                                ORDER BY biedingen.prijs DESC
                                ");
        $stmt->bind_param("i", $idadvertentie);
        $stmt->execute();

        $result = $stmt->get_result();
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $bedrijsnaam = $row['Bedrijfsnaam'];
                $prijs = str_replace(".",",",''.$row['prijs'].'');
                $logoglocatie = $row['logolocatie'];
                echo "<div class='bieding'><div class= 'bedrijfsnaam'>"."<img src='afbeeldingenUsers/profielIcons/$logoglocatie' class='biedingBedrijfIcons'><p>".$bedrijsnaam."</p></div><div class='prijs'>".'€ '.$prijs."</div></div>";
            }
        }
    }
?>