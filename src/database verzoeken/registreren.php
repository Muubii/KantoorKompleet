<?php
    session_start();
    require "ConnDb.php";


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $Bedrijfsnaam = $_POST['Bedrijfsnaam'];
    $myname = $_POST['Gebruikersnaam'];
    $mypassword = $_POST['Wachtwoord'];
    
    $hashedpassword = password_hash($mypassword, PASSWORD_DEFAULT);
    $stmt1 = $conn->prepare("SELECT idGebruiker FROM gebruiker WHERE Bedrijfsnaam = ?");
    $stmt1->bind_param("s", $Bedrijfsnaam);
    $stmt1->execute();
    $result = $stmt1->get_result();


    if($result->num_rows == 0){
        $stmt2 = $conn->prepare("INSERT INTO gebruiker (Bedrijfsnaam, Gebruikersnaam, Wachtwoord) VALUES (?, ?, ?)");
        $stmt2->bind_param("sss", $Bedrijfsnaam, $myname, $hashedpassword);
        if ($stmt2->execute()) {
            exit();
        } else {
            echo "Error: " . $stmt2->error;
        }
    }else{
        echo "Bedrijfsnaam is al in bezet";
    }
}
?>
