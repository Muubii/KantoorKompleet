<?php
    include 'php/checkSession.php';
    include 'database verzoeken/ConnDb.php';
    $idgebruiker = $_SESSION['idGebruiker'];
    
    $stmt = $conn->prepare("SELECT logolocatie, websitelink, bedrijfslocatie, mail, telefoon FROM gebruiker WHERE idGebruiker = ?");
    $stmt->bind_param("s", $idgebruiker);
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows == 1){
        $row = $result->fetch_assoc();
        $logolocatie = $row['logolocatie'];
        $websitelink = $row['websitelink'];
        $bedrijfslocatie = $row['bedrijfslocatie'];
        $mail = $row['mail'];
        $telefoon = $row['telefoon'];
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/profiel.css">
    <script src="js/header.js"></script>
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
        <div class="profielContainer">
            <form id="profielForm" enctype="multipart/form-data">
                <div class="profielForm">
                    <div class='bedrijfslogoBox'>
                        <?php
                            if(empty($logolocatie)){
                                echo '
                                <div class="imgBox">
                                    <img src="images/icons/uploadImage.svg" class="uploadImageIcon">
                                    <label for="LogoInput">upload bedrijfslogo hier</label>
                                    <input type="file" id="LogoInput" name="Logo" accept=".jpg,.png,.jpeg" class="fileInput">
                                </div>
                                ';
                            } else{
                                echo '<div class="imgBox hidden">
                                <img src="images/icons/uploadImage.svg" class="uploadImageIcon">
                                <label for="LogoInput">upload bedrijfslogo hier</label>
                                <input type="file" id="LogoInput" name="Logo" accept=".jpg,.png,.jpeg" class="fileInput">
                              </div>';
                    
                        echo "<img src='afbeeldingenUsers/profielIcons/$logolocatie' id='bedrijfslogo'>";
                            }
                        ?>
                    </div>
                    <div class="inputbox">
                        <div class="inputContainer">
                            <label for="websiteURLInput"><img src="images/icons/websiteicon.svg" alt="icon"><p>WebsiteURL:</p></label>
                            <input type="text" name="WebsiteURL" placeholder="WebsiteURL" id="websiteURLInput" value="<?php echo $websitelink?>">
                        </div>
                        <div class="inputContainer">
                            <label for="LocatieInput"><img src="images/icons/locatieicon.svg" alt="icon"><p>Locatie:</p></label>
                            <input type="text" name="Locatie" placeholder="Locatie" id="LocatieInput" value="<?php echo $bedrijfslocatie?>">
                        </div>
                        <div class="inputContainer">
                            <label for="MailInput"><img src="images/icons/mailicon.svg" alt="icon"><p>Mail:</p></label>
                            <input type="text" name="Mail" placeholder="Mail" id="MailInput" value="<?php echo $mail?>">
                        </div>
                        <div class="inputContainer">
                            <label for="TelefoonInput"><img src="images/icons/telefoonicon.svg" alt="icon"><p>Telefoon:</p></label>
                            <input type="text" name="Telefoon" placeholder="06 12 34 56 78" id="TelefoonInput" value="<?php echo $telefoon?>">
                        </div>
                        <button id="updateProfielBtn" type="submit"><p>Update Profiel</p></button>
                    </div>
   
                </div>
            </form>
        </div>
    </main>

    <script src="js/profiel.js"></script>
</body>
</html>