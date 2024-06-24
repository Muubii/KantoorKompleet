<?php
session_start();
include "ConnDb.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $myusername = $_POST['Gebruikersnaam'];
    $mypassword = $_POST['Wachtwoord'];

    // Gebruik voorbereidende verklaringen om SQL-injectie te voorkomen
    $stmt = $conn->prepare("SELECT * FROM Gebruiker WHERE Gebruikersnaam = ? ");
    $stmt->bind_param("s", $myusername);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    //$stmt->store_result();

        if($user && password_verify($mypassword,$user['Wachtwoord'])){
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
