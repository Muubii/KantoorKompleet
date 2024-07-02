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
    <script src="js/profiel.js"></script>
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
        <div class="profielContainer">
            <form id="profielForm" enctype="multipart/form-data">
                <div class="profielForm">
                    <div class='bedrijfslogoBox'>
                    <?php
                        if(empty($logolocatie)){
                            echo '<input type="file" id="LogoInput" name="Logo" accept=".jpg,.png,.jpeg"">';
                        } else{

                            echo "<img src='afbeeldingenUsers/profielIcons/".$logolocatie."' id = 'bedrijfslogo'>";
                        }
                    ?>
                    </div>
                    <div class="inputContainer">
                        <label for="websiteURLInput">WebsiteURL</label>
                        <input type="text" name="WebsiteURL" placeholder="WebsiteURL" id="websiteURLInput" value="<?php echo $websitelink?>">
                    </div>
                    <div class="inputContainer">
                        <label for="LocatieInput">Locatie</label>
                        <input type="text" name="Locatie" placeholder="Locatie" id="LocatieInput" value="<?php echo $bedrijfslocatie?>">
                    </div>
                    <div class="inputContainer">
                        <label for="LocatieInput">Mail</label>
                        <input type="text" name="Mail" placeholder="Mail" id="MailInput" value="<?php echo $mail?>">
                    </div>
                    <div class="inputContainer">
                        <label for="LocatieInput">Telefoon</label>
                        <input type="text" name="Telefoon" placeholder="06 1234 5678" id="TelefoonInput" value="<?php echo $telefoon?>">
                    </div>
                    <button id="updateProfielBtn" type="submit">Update Profiel</button>
                </div>
            </form>
        </div>
    </main>


</body>
</html>