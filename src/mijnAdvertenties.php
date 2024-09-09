<?php
    require "php/checkSession.php";
    $idgebruiker = $_SESSION['idGebruiker'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/mijnadvertenties.css">
    <link rel="stylesheet" href="css/header.css">
    <title>Document</title>
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
<div class="alleAdvertentiesbox">
        <?php
            require "database verzoeken/ConnDb.php";

            $sql1 = "SELECT advertentie.Naam as naamadvertentie,
                            advertentie.Prijs as prijs,
                            advertentie.biedenvanaf as biedenvanaf,
                            advertentie.beschrijving as beschrijving,
                            advertentie.idGebruiker as idgebruiker,
                            advertentie.idadvertentie as id,
                            advertentie.automatischeverwijdering as verwijderdatum,

                            afbeeldingen.afbeeldinglocatie as afbeeldinglocatie
            FROM advertentie
            INNER JOIN afbeeldingen USING (idadvertentie)
            WHERE advertentie.idgebruiker = ". $idgebruiker ." AND afbeeldingen.`order` = '1'
            ORDER BY automatischeverwijdering desc;";

                    


            // $sql2 = "SELECT afbeeldingen.afbeeldingLocatie AS locatie,
            //                 afbeeldingen.`order` AS orderimages
            //         FROM afbeeldingen
            //         WHERE idadvertentie = $idadvertentie
            //         GROUP BY afbeeldingen.`order`;";
                                
            $stmt = $conn->prepare($sql1);
            $stmt->execute();
            $result = $stmt->get_result();
            
            $firsttime = true;
            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
                    $naam_advertentie = $row['naamadvertentie'];
                    $prijs = str_replace(".",",",''.$row['prijs'].'');
                    $bieden_vanaf = str_replace(".",",",''.$row['biedenvanaf'].'');
                    $beschrijving = $row['beschrijving'];
                    $id_advertentie = $row['id'];
                    $logolocatie = $row['afbeeldinglocatie'];
                    $verwijderdatum = $row['verwijderdatum'];
                    $currentDate = date('Y-m-d H:i:s');
                    $class = null;
                    if ($verwijderdatum != "") {
                        $class = ($currentDate > $verwijderdatum) ? 'Gray' : '';
                    } else {
                        $class = "";
                    }
                    

                    if($class == "Gray" && $firsttime){
                        $firsttime = false;
                        echo "<div>";
                            echo "<h4>Automatisch Verwijderde advertenties</h4>";
                            echo "<hr>";
                            echo "<button id='verwijderVerwijderdeAdvertentieBtn'><img src='images/icons/deleteicon.svg' class='icon'>Verwijder Alles</button>";
                        echo "</div>";

                    }



                    echo "<div class='advertentiebox ".$class."' data-advertentieId='$id_advertentie'>";
                    echo "<img src='afbeeldingenUsers/".$logolocatie."' class='advertentieafbeelding'>";
                    echo "<div class='advertentieContent'>";
                        echo "<h4 class='advertentieNaam'>".$naam_advertentie."</h4>";
                        echo "<p class='advertentiePrijs'>"."€".$prijs."</p>";
                        echo "<p class='advertentieDatum'>Verwijderdatum: ".$verwijderdatum."</p>";
                    echo "</div>";
                echo "</div>";
                
                }
            }else{
                echo "Geen advertenties geplaatst";
            }


            // $stmt = $conn->prepare($sql2);
            // $stmt->execute();
            // $result = $stmt->get_result();

            // if($result->num_rows > 0){
            //     $locaties = [];
            //     while($row = $result->fetch_assoc()){
            //         array_push($locaties, $row['locatie']);
            //     }
            // }else{
            //     echo "de advertentie bestaat niet";
            // }
        ?>
</div>
    </main>
<script src="js/header.js"></script>
<script src="js/mijnadvertenties.js"></script>
</body>
</html>