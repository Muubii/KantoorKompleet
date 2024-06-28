<?php
include 'php/checkSession.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/header.css">
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
                <button id="chatbtn" onclick="location.href='chat.html'"><img src="images/icons/chatIcon.svg" alt="icon" class="navIcon">Berichten</button>
                <button id="plaatsaddbtn" onclick="location.href='plaatsadvertentie.php'"><img src="images/logoSmall.svg" alt="icon" class="navIcon">Nieuwe Advertentie</button>
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

            <div class="profielForm">
                <label for="">Logo</label>
                <input type="file">
                <div class="inputContainer">
                    <label for="websiteURLInput">WebsiteURL</label>
                    <input type="text" name="websiteURL" placeholder="websiteURL" id="websiteURLInput">
                </div>
                <div class="inputContainer">
                    <label for="LocatieInput">Locatie</label>
                    <input type="text" name="Locatie" placeholder="Locatie" id="LocatieInput">
                </div>
                <div class="inputContainer">
                    <label for="LocatieInput">Mail</label>
                    <input type="text" name="Mail" placeholder="Mail" id="MailInput">
                </div>
                <div class="inputContainer">
                    <label for="LocatieInput">Telefoon</label>
                    <input type="text" name="Telefoon" placeholder="Telefoon" id="TelefoonInput">
                </div>
            </div>

        </div>
    </main>


</body>
</html>