<?php
session_start();
if(!isset($_SESSION['Bedrijfsnaam']) || !isset($_SESSION['idGebruiker'])) {
    header("Location: login.html");
    exit(); // Zorg ervoor dat er geen code meer wordt uitgevoerd na het doorsturen
}
?>
