<?php
    session_start();
    require 'ConnDb.php';
    $idgebruiker = $_SESSION['idGebruiker'];
    print_r($_POST);


    $idAdvertentie = $_POST['id'];
    $naam = $_POST['naam'];
    $prijs = $_POST['prijs'];
    $biedenvanaf = $_POST['biedenvanaf'];
    $verwijderdatum = $_POST['verwijderdatum'];
    $beschrijving = $_POST['beschrijving'];
    if(isset($naam, $prijs, $biedenvanaf, $verwijderdatum, $beschrijving)){
        $stmt = $conn->prepare("UPDATE advertentie
                                SET naam = ?, prijs = ?, biedenvanaf = ?, automatischeverwijdering = ?, beschrijving = ?
                                WHERE idadvertentie = ?
                                ");

        $stmt->bind_param("sddssi", $naam ,$prijs, $biedenvanaf, $verwijderdatum, $beschrijving, $idAdvertentie);
        $stmt->execute();
    } else{
        echo "niet gezet";
    }

    echo "Goed geupdate";
?>