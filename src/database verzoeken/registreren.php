<?php
    session_start();
    include "ConnDb.php";


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {

    $Bedrijfsnaam = $_POST['Bedrijfsnaam'];
    $myname = $_POST['Gebruikersnaam'];
    $mypassword = $_POST['Wachtwoord'];
    
    $hashedpassword = password_hash($mypassword, PASSWORD_DEFAULT);
    // Prepare SQL statement
    $stmt1 = $conn->prepare("SELECT (Bedrijfsnaam) FROM Gebruiker WHERE Bedrijfsnaam = ?");
    $stmt1->bind_param("s", $Bedrijfsnaam);

    $stmt1->execute();
    $result = $stmt1->get_result();
    if($result->num_rows == 0){
        $stmt2 = $conn->prepare("INSERT INTO Gebruiker (Bedrijfsnaam, Gebruikersnaam, Wachtwoord) VALUES (?, ?, ?)");
        // Bind parameters to the SQL statement
        $stmt2->bind_param("sss", $Bedrijfsnaam, $myname, $hashedpassword);

        // Execute the SQL statement
        if ($stmt2->execute()) {
            header("location: /login.html");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
    }else{
        echo "Bedrijfsnaam is al in bezet";
    }
}
?>
