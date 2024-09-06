<?php
    require "php/checkSession.php";
    require "database verzoeken/ConnDb.php";

    if(isset($_GET['id']) && !empty($_GET['id'])){
        if(is_numeric($_GET['id'])){
            $idadvertentie = $_GET['id'];
            $sql1 = "SELECT advertentie.Naam as naamadvertentie,
                            advertentie.Prijs as prijs,
                            advertentie.biedenvanaf as biedenvanaf,
                            advertentie.beschrijving as beschrijving,
                            advertentie.idGebruiker as idgebruiker,
                            advertentie.idadvertentie as id,
                            advertentie.automatischeverwijdering as verwijderdatum,
    
                            gebruiker.Bedrijfsnaam as bedrijfsnaam,
                            gebruiker.mail as mail,
                            gebruiker.logolocatie as logolocatie,
                            gebruiker.telefoon as telefoon,
                            gebruiker.bedrijfslocatie as bedrijfslocatie,
                            gebruiker.websitelink as websitelink
                    FROM advertentie
                    INNER JOIN gebruiker on gebruiker.idgebruiker = advertentie.idgebruiker
                    WHERE idadvertentie =". $idadvertentie .";";
                    
    
    
                    $sql2 = "SELECT afbeeldingen.afbeeldingLocatie AS locatie,
                                    afbeeldingen.`order` AS orderimages
                            FROM afbeeldingen
                            WHERE idadvertentie = $idadvertentie
                            GROUP BY afbeeldingen.`order`;";
                                    
                     
    
            $sql3 = "SELECT categorie.naam as naamcategorie
                     FROM advertentieCategorieën
                     INNER JOIN categorie on categorie.idcategorie = advertentieCategorieën.idcategorie
                     WHERE idadvertentie =". $idadvertentie .";";
            
    
        
           $sql4 = "SELECT biedingen.idadvertentie, biedingen.prijs, biedingen.idGebruiker, gebruiker.Bedrijfsnaam, gebruiker.logolocatie
                    FROM biedingen
                    INNER JOIN gebruiker
                    USING (idGebruiker)
                    WHERE idadvertentie = $idadvertentie
                    ORDER BY biedingen.prijs DESC;
           ";

            $stmt = $conn->prepare($sql1);
            $stmt->execute();
            $result = $stmt->get_result();
            if($result->num_rows > 0){
                $row = $result->fetch_assoc();
                $naam_advertentie = $row['naamadvertentie'];
                $prijs = str_replace(".",",",''.$row['prijs'].'');
                $bieden_vanaf = str_replace(".",",",''.$row['biedenvanaf'].'');
                $beschrijving = $row['beschrijving'];
                $id_gebruiker = $row['idgebruiker'];
                $bedrijfsnaam = $row['bedrijfsnaam'];
                $verwijderdatum = $row['verwijderdatum'];
                $id_advertentie = $row['id'];
    
                $telefoon = $row['telefoon'];
                $mail = $row['mail'];
                $websiteURL = $row['websitelink'];
                $bedrijfslocatie = $row['bedrijfslocatie'];
                $logolocatie = $row['logolocatie'];
            }else{
                echo "de advertentie bestaat niet";
            }
    
            $stmt = $conn->prepare($sql2);
            $stmt->execute();
            $result = $stmt->get_result();
            if($result->num_rows > 0){
                $locaties = [];
                while($row = $result->fetch_assoc()){
                    array_push($locaties, $row['locatie']);
                }
            }else{
                echo "de advertentie bestaat niet";
            }
    
            $stmt = $conn->prepare($sql3);
            $stmt->execute();
            $result = $stmt->get_result();
            if($result->num_rows > 0){
                $naam_categorie = [];
                while($row = $result->fetch_assoc()){
                    array_push($naam_categorie, $row['naamcategorie']);
                };
            }else{
                echo "de advertentie bestaat niet";
            }
    
    
    
    
    
        }
    }else{
        echo "Geen geldige advertentie";
    }


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/advertentieinfo.css">
    <title>Advertentie bewerken</title>
</head>
<body>
<header>
        <div class="headerContent">
            <div class="logoBox">
                <img src="images/logo.svg" alt="logoKantoorCompleet" class="logo" onclick="location.href='/'">
                <p class="logoTekst">Kantoor Compleet</p>
            </div>

            <nav class="headerNav">
                <button id="hamburgerMenu"><img src="images/icons/hamburgericon.svg" class="icon" alt="icon"></button>
                <button id="chatbtn" class="navBtn btnIcon"><img src="images/icons/chatIcon.svg" alt="icon" class="icon">Berichten</button>
                <button id="plaatsaddbtn" class="navBtn btnIcon"><img src="images/logoSmall.svg" alt="icon" class="icon">Nieuwe advertentie</button>
                <button id="mijnaddbtn" class="navBtn btnIcon"><img src="images/icons/mijnadvertentiesicon.svg" alt="icon" class="icon">Mijn advertenties</button>
                <div class="user_acc">
                    <div class="usericonbox"><img src="images/icons/personIcon.svg" class="personIcon"></div>
                    <div class="usermenubox">
                        <ul class="listUserOptions">
                            <li class="useroption profiel">Profiel</li>
                            <li class="useroption uitloggen">Uitloggen</li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
</header>


<main>
    <div class="advertentieInfoBox">
        <div class="afbeeldingenBox">
            <div class="mainImageBox">
                <img class="mainImage">
            </div>
            <div class="allImagesBox">
                <?php

                $aantalFotosAdvertentie = count($locaties);
                foreach($locaties as $afbeeldingslocatie){
                    echo '<div class="advertentieAfbeeldingBox">
                            <img src= afbeeldingenUsers/'.$afbeeldingslocatie.' class="advertentieAfbeelding">

                        </div>';
                }
                                            // <div class="tile" style="order: 1;"><span class="noselect orderNumber">1</span></div>
                if($aantalFotosAdvertentie < 10){
                    for($i = 0; $i < 10-$aantalFotosAdvertentie; $i++){
                        echo '<div class="advertentieAfbeeldingBox"></div>';
                    }
                }
                ?>
            </div>

        </div>
            <div class="InfoadvertentieBox">
                <div class="naam infoBox">
                    <label for="">Naam:</label>
                    <?php
                      echo "<input value='". $naam_advertentie ."' disabled ='true' class='infoInput' name='naamAdvertentie'>";
                    ?>
                    <button class="bewerkInfoBtn"><img src="images/icons/editteksticon.svg" class="icon"></button>
                </div>
                <div class="verwijderdatum infoBox">
                <label for="">Verwijderdatum:</label>
                    <?php
                    echo "<input type='datetime-local' value='". $verwijderdatum ."' disabled ='true' class='infoInput' name='verwijderDatum'>";

                    ?>
                    <button class="bewerkInfoBtn"><img src="images/icons/editteksticon.svg" class="icon"></button>                     
                </div>
                <div class="prijs infoBox">
                <label for="">Prijs: €</label>
                    <?php
                      echo "<input value='". $prijs ."' disabled ='true' class='infoInput geldInput' name='prijs'>";
                    ?>
                    <button class="bewerkInfoBtn"><img src="images/icons/editteksticon.svg" class="icon"></button>                     
                </div>
                <div class="biedenvanaf infoBox">
                <label for="">bieden vanaf: €</label>
                    <?php
                        echo "<input value='". $bieden_vanaf ."' disabled ='true' class='infoInput geldInput' name='biedenVanaf'>";
                    ?>
                    <button class="bewerkInfoBtn"><img src="images/icons/editteksticon.svg" class="icon"></button>
                </div>
                <div class="beschrijving infoBox">
                    <label for="">Beschrijving:</label>
                    <textarea disabled ="true" class='infoInput beschrijvingsInput' name='beschrijving'><?php echo $beschrijving;?></textarea>
                    <button class="bewerkInfoBtn"><img src="images/icons/editteksticon.svg" class="icon"></button>
                </div>
            </div>
            <div class="biedingsBox">
            <fieldset>
                <legend>Biedingen</legend>
                <?php
                    $stmt = $conn->prepare($sql4);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    if($result->num_rows > 0){
                        while($row = $result->fetch_assoc()){
                            $bedrijsnaam = $row['Bedrijfsnaam'];
                            $prijs = str_replace(".",",",''.$row['prijs'].'');
                            $logolocatie = $row['logolocatie'];
                            echo"<div class='bieding'>
                                    <div class= 'bedrijfsnaam'>".
                                        "<img src='afbeeldingenUsers/profielIcons/$logolocatie' class='biedingBedrijfIcons'>
                                        <p>".$bedrijsnaam."</p>
                                    </div>
                                    <div class='geldEnChatBox'>
                                        <p class='prijs'>".'€'.$prijs."</p>
                                        <button class='startChatBtn'><img src='images/icons/chaticon.svg' class='startChatIcon'></button>
                                    </div>
                                </div>";
                        }
                    } else{
                        echo "geen biedingen op dit moment";
                    }
                ?>
            </fieldset>
            </div>
            <div class="update-verwijderBtnsBox">
                <button id="verwijderAdvertentieBtn">Verwijder advertentie</button>
                <button id="UpdateAdvertentieBtn">Update advertentie</button>                
            </div>

    </div>
</main>

<script src="js/geldinput.js"></script>
<script src="js/header.js"></script>
<script src="js/advertentieinfo.js"></script>
<script src="js/sorteblegrid.js"></script>

</body>
</html>