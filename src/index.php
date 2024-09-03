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
    <link rel="stylesheet" href="css/ads.css">
    <link rel="stylesheet" href="css/zoekfilter.css">
    <link rel="stylesheet" href="css/header.css">
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

            <form class="filter" id="filteradvertenties">
                <div class="topOfGrid">
                    <button class="filtericon" type="button"><img src="images\icons\filtericon.svg" alt="icon" class="icon"></button>
                    <input type="text" placeholder="Zoeken" id="zoekInput" name="zoekInput">
                    <div class="extraFilters">
                        <select id="categorieënInput" name="categorieënInput">
                        <option value="0">alle categorieën</option>
                        </select>
                        <input type="text" placeholder="van" id="vanPrijsInput" class="geldInput" name="vanPrijsInput">
                        <input type="text" placeholder="tot" id="totPrijsInput" class="geldInput" name="totPrijsInput">
                    </div>

                <button type="submit" class="btnIcon"><img src="images/icons/zoekicon.svg" class="icon">zoeken</button>
                </div>
                <div class="bottomOfGrid"></div>
            </form>

        </div>
    </header>

    <main>
        <div class="advertentieBox"></div>
    </main>
    <footer></footer>
    <script src="js/header.js"></script>
    <script src="js/zoekbar.js"></script>
    <script src="js/index.js"></script>
    <script src="js/geldinput.js"></script>
</body>
</html>