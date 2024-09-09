<?php
    session_start();
    require 'ConnDb.php';
    $idgebruiker = $_SESSION['idGebruiker'];
    print_r($_POST);


    $idAdvertentie = $_POST['id'];
    $naam = $_POST['naam'];
    $prijs =  str_replace(',', '.', $_POST['prijs']);
    $biedenvanaf = str_replace(',', '.', $_POST['biedenvanaf']);
    $verwijderdatum = empty($_POST['verwijderdatum']) ? null : $_POST['verwijderdatum'];
    $beschrijving = $_POST['beschrijving'];
    $JSONvolgordeAfbeeldingen = $_POST['order'];
    
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

    
    $stmt = $conn->prepare("DELETE FROM afbeeldingen WHERE idadvertentie = ?
                            ");

    $stmt->bind_param("s", $idAdvertentie);
    $stmt->execute();

    $volgordeAfbeeldingen = json_decode($JSONvolgordeAfbeeldingen);
    print_r($volgordeAfbeeldingen);
    $valuesString = "";
    foreach($volgordeAfbeeldingen as $key => $order){
        $valuesString .= "($idAdvertentie,'$key', $order),";
    }
    $valuesString = rtrim($valuesString,",");
    echo $valuesString;
    $stmt = $conn->prepare("INSERT INTO afbeeldingen (idadvertentie, afbeeldinglocatie, `order`) VALUES $valuesString");
    
    $stmt->execute();

    echo "Goed geupdate";
?>