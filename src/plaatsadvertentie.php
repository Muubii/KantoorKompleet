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
    <script src="js/header.js"></script>
    <script src="js/sorteblegrid.js"></script>
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
                <button id="plaatsaddbtn" onclick="location.href='plaatsadvertentie.html'"><img src="images/logoSmall.svg" alt="icon" class="navIcon">Nieuwe Advertentie</button>
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
                        <label for="naam">Naam:</label>
                        <input type="text" id="naam" name="naam">
                    </div>
                    <div class="inputbox categorieënInput">
                        <span class="verplicht">(verplicht)</span>
                        <div class="TopOfBox">
                            <label>Categorieën<img src="images/icons/arrow.svg" alt="icon" class="arrowIcon" onclick="bekijkCategorien()"></label>
                            <hr>
                            <div class="selectedCategorieën"></div>
                        </div>
                        <div class="categoriënbox">
                            <div>Meubilair</div>
                            <div>Computers en Randapparatuur</div>
                            <div>Printers en Scanners</div>
                            <div>Telefoon- en Communicatiesystemen</div>
                            <div>Koffiemachines</div>
                            <div>Archiefkasten</div>
                            <div>Vergadertafels en Stoelen</div>
                            <div>Projectoren en Presentatieschermen</div>
                            <div>Veiligheidsapparatuur</div>
                            <div>Decoratie en Kunst</div>
                            <div>Opbergrekken en Ladekasten</div>
                            <div>Keukenapparatuur</div>
                            <div>Stoelen en Bureaustoelen</div>
                            <div>Reinigingsapparatuur</div>
                            <div>Verlichting</div>
                            <div>Werkplekaccessoires</div>
                        </div>
                    </div>
                    <div class="inputbox prijsbox">
                        <span class="verplicht">(verplicht)</span>

                        <label for="prijs">Prijs:</label>
                        <div>
                            <input type="text" id="prijs" placeholder="0,00" name="prijs">
                            <span>€</span>
                        </div>

                        <label for="bieden">Bieden vanaf:</label>
                        <div>
                            <input type="text" id="bieden" placeholder="0,00" name="bieden vanaf">
                            <span>€</span>
                        </div>
                        
                    </div>
                    <div class="inputbox">
                        <label for="timeForDeletion">Automatische verwijdering:</label>
                        <input type="date" id="timeForDeletion" name="Automatische verwijdering">
                    </div>

                    <div class="inputbox beschrijfingsbox">
                        <span class="verplicht">(verplicht)</span>
                        <label for="beschrijfing">Beschrijfing:</label>
                        <textarea name="beschrijfing" placeholder="Een korte beschrijfing over het product" id="beschrijfing"></textarea>
                    </div>

                    <button type="submit" id="submitBtn">Plaats advertentie</button>
                </div>
            </form>
        </div>
    </main>
</body>
<script src="js/plaatsadvertentie.js"></script>
</html>