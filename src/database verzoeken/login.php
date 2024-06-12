<?php
session_start();
include "ConnDb.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $myusername = $_POST['Gebruikersnaam'];
    $mypassword = $_POST['Wachtwoord'];

    // Gebruik voorbereidende verklaringen om SQL-injectie te voorkomen
    $stmt = $conn->prepare("SELECT Gebruikersnaam FROM Gebruiker WHERE Gebruikersnaam = ? AND Wachtwoord = ?");
    $stmt->bind_param("ss", $myusername, $mypassword);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
        $_SESSION['login_user'] = $myusername;
        header("Location: /index.html");
        exit();
    } else {
        echo "Ongeldige gebruikersnaam of wachtwoord.";
    }

    $stmt->close();
    $conn->close();
}
?>
