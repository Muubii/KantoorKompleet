<?php
    require "php/checkSession.php";
    require "database verzoeken/ConnDb.php";
    $idGebruiker = $_SESSION['idGebruiker'];

    $id_advertentie = $_GET['id'];

    if(isset($id_advertentie) && !empty($id_advertentie)){
        if(is_numeric($id_advertentie)){

            $sql0 = "SELECT idadvertentie 
                    FROM advertentie
                    WHERE idadvertentie = $id_advertentie;";

            $stmt = $conn->prepare($sql0);
            $stmt->execute();
            $result = $stmt->get_result();

            $idadvertenties = [];
            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
                array_push($idadvertenties, $row['idadvertentie']);
                };
            }

        if (!in_array($id_advertentie, $idadvertenties)) {
            header("Location: mijnadvertenties.php");
            exit();
        }






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
                    WHERE idadvertentie =". $id_advertentie .";";
                    
    
    
                    $sql2 = "SELECT afbeeldingen.afbeeldingLocatie AS locatie,
                                    afbeeldingen.`order` AS orderimages
                            FROM afbeeldingen
                            WHERE idadvertentie = $id_advertentie
                            GROUP BY afbeeldingen.`order`;";
                                    
                     
    
            $sql3 = "SELECT categorie.naam as naamcategorie
                     FROM advertentieCategorieën
                     INNER JOIN categorie on categorie.idcategorie = advertentieCategorieën.idcategorie
                     WHERE idadvertentie =". $id_advertentie .";";
            
    
        
           $sql4 = "SELECT biedingen.idadvertentie, biedingen.prijs, biedingen.idGebruiker, gebruiker.Bedrijfsnaam, gebruiker.logolocatie
                    FROM biedingen
                    INNER JOIN gebruiker
                    USING (idGebruiker)
                    WHERE idadvertentie = $id_advertentie
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
    
                $telefoon = $row['telefoon'];
                $mail = $row['mail'];
                $websiteURL = $row['websitelink'];
                $bedrijfslocatie = $row['bedrijfslocatie'];
                $logolocatie = $row['logolocatie'];
            }else{
                header("Location: mijnadvertenties.php");
                exit();
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
                header("Location: mijnadvertenties.php");
                exit();
                
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
                header("Location: mijnadvertenties.php");
                exit();
            }
    
    
    
        }
    
        
    }else{
        header("Location: mijnadvertenties.php");
        exit();
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
    <link rel="stylesheet" href="css/sorteblegrid.css">
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
        <div class="afbeeldingenBoxWrapper">
            <div class="afbeeldingenBox">
                <div class="mainImageBox">
                    <img class="mainImage">
                </div>
                <div class="allImagesBox">
                    <?php

                    $aantalFotosAdvertentie = count($locaties);
                    foreach($locaties as $index => $afbeeldingslocatie){
                        echo '<div class="tile" style="order: '.($index + 1).';"><img src="afbeeldingenUsers/'.$afbeeldingslocatie.'" class="advertentieAfbeelding"><span class="noselect orderNumber">'.($index + 1).'</span></div>';
                    }
                    if($aantalFotosAdvertentie < 10){
                        for($i = $aantalFotosAdvertentie+1; $i <= 10; $i++){
                            echo '<div class="tile" style="order: '.$i.';"><span class="noselect orderNumber">'.$i.'</span></div>';
                        }
                    }
                    echo '<div class="placeholder-tile" style="order: 10;"></div>';
                    ?>
                </div>

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
                        $bedrijfsnaam = $row['Bedrijfsnaam'];
                        $prijs = str_replace(".",",",''.$row['prijs'].'');
                        $logolocatie = $row['logolocatie'];
                        $idGebruiker = $row['idGebruiker']; // Assign the user ID to a variable
                        
                        echo "<div class='bieding'>
                                <div class='bedrijfsnaam'>
                                    <img src='afbeeldingenUsers/profielIcons/$logolocatie' class='biedingBedrijfIcons'>
                                    <p>$bedrijfsnaam</p>
                                </div>
                                <div class='geldEnChatBox'>
                                    <p class='prijs'>€$prijs</p>
                                    <button onclick='startChat($idGebruiker)' class='startChatBtn'>
                                        <img src='images/icons/chaticon.svg' class='startChatIcon'>
                                    </button>
                                </div>
                            </div>";
                    }
                } else {
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
<script src="js/chat.js"></script>
<script src="js/sorteblegrid.js"></script>
<script src="js/advertentieinfo.js"></script>
</body>
</html>