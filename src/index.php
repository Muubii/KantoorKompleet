<?php
    include 'php/checkSession.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="images/logoSmall.svg" type="image/icon type">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/ads.css">
    <script src="js/header.js"></script>
    <script src="js/index.js"></script>
    <title>Kantoor Compleet</title>
</head>
<body>
    <header>
        <div class="headerContent">
            <div class="logoBox">
                <img src="images/logo.svg" alt="logoKantoorCompleet" class="logo" onclick="location.href='/'">
                <p class="logoTekst">Kantoor Compleet</p>
            </div>

            <nav class="headerNav">
            <a href="chat.php"><button id="chatbtn"><img src="images/icons/chatIcon.svg" alt="icon" class="navIcon">Berichten</button></a>
                <button id="plaatsaddbtn"><img src="images/logoSmall.svg" alt="icon" class="navIcon">Nieuwe advertentie</button>
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

            <nav class="filter">
                <input type="text" placeholder="Zoeken">
                <Select>
                <option value="">categorieën</option>
                </Select>
                <input type="text" placeholder="van">
                <input type="text" placeholder="tot">
            </nav>
        </div>
    </header>

    <main>
        <div class="advertentieBox">

        </div>
    </main>
    <footer></footer>
</body>
</html>