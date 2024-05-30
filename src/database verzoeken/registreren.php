<?php
    session_start();
    include "ConnDb.php";


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {

    $myname = $_POST['Naam'];
    $myusername = $_POST['Gebruikersnaam'];
    $mypassword = $_POST['Wachtwoord'];
    

    // Prepare SQL statement
    $stmt = $conn->prepare("INSERT INTO Gebruiker (Naam, Gebruikersnaam, Wachtwoord) VALUES (?, ?, ?)");

    // Bind parameters to the SQL statement
    $stmt->bind_param("sss", $myname, $myusername, $mypassword);

    // Execute the SQL statement
    if ($stmt->execute()) {
        header("location: /login.html");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
