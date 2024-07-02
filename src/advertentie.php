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
    <title>Advertentie</title>
    <link rel="icon" href="images/logoSmall.svg" type="image/icon type">
    <link rel="stylesheet" href="css/advertentie.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="js/header.js"></script>
    <script src ="js/advertentie.js"></script>
</head>
<body>

<header>
    <div class="headerContent">
        <div class="logoBox">
            <img src="images/logo.svg" alt="logoKantoorCompleet" class="logo" onclick="location.href='/'">
            <p class="logoTekst">Kantoor Compleet</p>
        </div>
        <nav class="headerNav">
            <button id="chatbtn"><img src="images/icons/chatIcon.svg" alt="icon" class="navIcon">Berichten</button>
            <button id="plaatsaddbtn"><img src="images/logoSmall.svg" alt="icon" class="navIcon">Nieuwe Advertentie</button>
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
    <div class="container">
        <div class="product-details">
            <h1><?php echo $naam_advertentie?></h1>
            <div class="product-images">
                <img id="main-image">
                <div class="thumbnails">
                    <?php
                        foreach($locaties as $locatie ){
                            echo "<img src="."afbeeldingenUsers/".$locatie.">";
                        }

                    ?>
                </div>
            </div>
            <div class="price">€ <?php echo $prijs;?></div>
            <div class="features">
                <div><span>Advertentie ID: </span><?php print_r($id_advertentie);?></div>
                <div><span>Categorieën: </span><?php foreach($naam_categorie as $categorie){echo " #".$categorie;}?></div>
                <div><span>Beschrijving:<br> </span><?php echo $beschrijving?></div>
            </div>
        </div>
        <div class="sidebar">
            <div class="seller-info">
                <img src="afbeeldingenUsers/profielIcons/<?php echo $logolocatie?>" id = "logoVerkooper">
                <h3><?php echo $bedrijfsnaam;?></h3>
                <p><?php echo $bedrijfslocatie?></p>
                <p><?php echo $mail?></p>
                <p><?php echo $telefoon?></p>
                <button onclick="window.open('<?php echo $websiteURL; ?>', '_blank')">Website</button>
            </div>

            <input type="hidden" id="idadvertentie" value="<?php echo $id_advertentie; ?>">
          <input type="hidden" id="bieder" value="<?php echo $_SESSION['idGebruiker']; ?>"> 
             <button onclick="createChat()"  class="contact-seller">Start Chat</button>
            <div class="bid-section">
                <h3>Bieden vanaf: <?php echo "€ ".$bieden_vanaf;?></h3>
                <div id="biedingenBox"></div>
                <input type="number" placeholder="€" id="inputBiedingBox">
                <button id="plaatsBodBtn">Plaats bod</button>
            </div>
        </div>
    </div>
    <script src="js/advertentie.js"></script>
    <script src="js/chat.js"></script>
</body>
</html>


