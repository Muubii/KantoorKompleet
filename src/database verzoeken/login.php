<?php
session_start();
require "ConnDb.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Bedrijfsnaam = $_POST['Bedrijfsnaam'];
    $mypassword = $_POST['Wachtwoord'];

    // Gebruik voorbereidende verklaringen om SQL-injectie te voorkomen
    $stmt = $conn->prepare("SELECT * FROM gebruiker WHERE Bedrijfsnaam = ? ");
    $stmt->bind_param("s", $Bedrijfsnaam);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

        if($user && password_verify($mypassword,$user['Wachtwoord'])){
            $idGebruiker = $user['idGebruiker'];
            $_SESSION['idGebruiker'] = $idGebruiker;
            $_SESSION['Bedrijfsnaam'] = $Bedrijfsnaam;
    } else {
        echo "Ongeldige gebruikersnaam of wachtwoord.";
    }
 
    $stmt->close();
    $conn->close();
}
?>
