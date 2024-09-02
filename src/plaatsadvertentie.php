<?php
    require "php/checkSession.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plaats advertentie</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/plaatsadvertentie.css">
    <link rel="stylesheet" href="css/sorteblegrid.css">
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
       <div class="uploadAdvertentieBox">

            <div class="uploadImgBox">
                <div class="imgBox">
                    <img src="images/icons/uploadImage.svg" class="uploadImageIcon">
                    <label for="uploadFile">upload afbeeldingen hier</label>
                    <input type="file" id="uploadFile" multiple accept=".jpg,.png,.jpeg">
                </div>
                <div class="imgSlider">
                    <div class="tile" style="order: 1;"><span class="noselect orderNumber">1</span></div>
                    <div class="tile" style="order: 2;"><span class="noselect orderNumber">2</span></div>
                    <div class="tile" style="order: 3;"><span class="noselect orderNumber">3</span></div>
                    <div class="tile" style="order: 4;"><span class="noselect orderNumber">4</span></div>
                    <div class="tile" style="order: 5;"><span class="noselect orderNumber">5</span></div>
                    <div class="tile" style="order: 6;"><span class="noselect orderNumber">6</span></div>
                    <div class="tile" style="order: 7;"><span class="noselect orderNumber">7</span></div>
                    <div class="tile" style="order: 8;"><span class="noselect orderNumber">8</span></div>
                    <div class="tile" style="order: 9;"><span class="noselect orderNumber">9</span></div>
                    <div class="tile" style="order: 10;"><span class="noselect orderNumber">10</span></div>
                    <div class="placeholder-tile" style="order: 10;"></div>
                </div>
            </div>

            <form id="advertentiegegevens">
                <div class="inputform">
                    <div class="inputbox">
                        <span class="verplicht">(verplicht)</span>
                        <label>Naam:</label>
                        <input type="text" name="naam" required placeholder="Naam" maxlength="30">
                    </div>
                    <div class="inputbox categorieënInput">
                        <span class="verplicht">(verplicht)</span>
                        <div class="TopOfBox">
                            <label for="categorieënbox">Categorieën<img src="images/icons/arrow.svg" alt="icon" class="arrowIcon" onclick="bekijkCategorien()"></label>
                            <hr>
                            <div class="selectedCategorieën"></div>
                        </div>
                        <div class="categoriënbox" id = "categorieënbox"></div>
                    </div>
                    <div class="inputbox prijsbox">
                        <span class="verplicht">(verplicht)</span>

                        <label for="prijs">Prijs:</label>
                        <div>
                            <input type="text" id="prijs" placeholder="0,00" name="prijs" required class="geldInput" >
                            <span>€</span>
                        </div>

                        <label for="bieden">Bieden vanaf:</label>
                        <div>
                            <input type="text" id="bieden" placeholder="0,00" name="bieden vanaf" required class="geldInput">
                            <span>€</span>
                        </div>
                        
                    </div>
                    <div class="inputbox">
                        <label for="timeForDeletion">Automatische verwijdering:</label>
                        <input type="datetime-local" id="timeForDeletion" name="automatische verwijdering">
                    </div>

                    <div class="inputbox beschrijfingsbox">
                        <span class="verplicht">(verplicht)</span>
                        <label for="Beschrijving">Beschrijving:</label>
                        <textarea name="beschrijving" placeholder="Een korte beschrijfing over het product" id="beschrijving" required maxlength="300"></textarea>
                    </div>

                    <button type="submit" id="submitBtn">Plaats advertentie</button>
                </div>
            </form>
        </div>
    </main>
    <script src="js/header.js"></script>
    <script src="js/sorteblegrid.js"></script>
    <script src="js/geldinput.js"></script>
</body>
<script src="js/plaatsadvertentie.js"></script>
</html>