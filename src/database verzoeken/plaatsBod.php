<?php
    session_start();
    require "ConnDb.php";

    if(isset($_POST['advertentieid']) && !empty($_POST['advertentieid']) &&
       isset($_POST['prijs']) && !empty($_POST['prijs']) &&
       isset($_SESSION['idGebruiker']) && !empty($_SESSION['idGebruiker'])){
        
        $idadvertentie = $_POST['advertentieid'];
        $idGebruiker = $_SESSION['idGebruiker'];
        $prijs = $_POST['prijs'];

        $stmt = $conn->prepare("INSERT INTO biedingen (idadvertentie, prijs, idGebruiker) VALUES (?, ?, ?)");
        $stmt->bind_param("idi", $idadvertentie, $prijs, $idGebruiker);
        $stmt->execute();
    }
?>