<?php
session_start();
include "ConnDb.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $Bedrijfsnaam = $_POST['Bedrijfsnaam'];
    $mypassword = $_POST['Wachtwoord'];

    // Gebruik voorbereidende verklaringen om SQL-injectie te voorkomen
    $stmt = $conn->prepare("SELECT * FROM Gebruiker WHERE Bedrijfsnaam = ? ");
    $stmt->bind_param("s", $Bedrijfsnaam);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

        if($user && password_verify($mypassword,$user['Wachtwoord'])){
            $_SESSION['Bedrijfsnaam'] = $Bedrijfsnaam;
            header("Location: /index.php");
            exit();
    } else {
        echo "Ongeldige gebruikersnaam of wachtwoord.";
    }
 
    $stmt->close();
    $conn->close();
}
?>
