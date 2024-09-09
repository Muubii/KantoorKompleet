<?php
    session_start();
    require 'ConnDb.php';

    $idGebruiker = $_SESSION['idGebruiker'];

    if($idGebruiker){
        $stmt = $conn->prepare('SELECT idadvertentie FROM advertentie WHERE idGebruiker = ? AND automatischeverwijdering < NOW()');
        $stmt->bind_param("i", $idGebruiker);
        $stmt->execute();
        $result = $stmt->get_result();

        $idAdvertentieArr = [];
        while($row = $result->fetch_assoc()){
            print_r($row);
            $idAdvertentieArr[] = $row['idadvertentie'];
        }
        print_r($idAdvertentieArr);
    if(!empty($idAdvertentieArr)){


        $typesString = str_repeat('i', count($idAdvertentieArr));
        $vraagtekensString = str_repeat('?,', count($idAdvertentieArr));
        $vraagtekensString = rtrim($vraagtekensString, ",");

        $stmt = $conn->prepare('SELECT afbeeldinglocatie FROM afbeeldingen WHERE idadvertentie IN ('.$vraagtekensString.')');
        $stmt->bind_param($typesString,...$idAdvertentieArr);
        $stmt->execute();
        
        $result = $stmt->get_result();
        while($row = $result->fetch_assoc()){
        foreach($row as $filename){
            if (file_exists("../afbeeldingenUsers/".$filename)) {
                if(unlink("../afbeeldingenUsers/".$filename)){
                    echo "afbeeldingen verwijdert";
                }else{
                    echo "kon afbeeldingen niet verwijderen";
                }
            } else {
                echo 'Could not delete '.$filename.', file does not exist';
            }    
            }
        }


        $stmt = $conn->prepare('DELETE FROM advertentieCategorieën WHERE idadvertentie IN ('.$vraagtekensString.')');
        $stmt->bind_param($typesString,...$idAdvertentieArr);
        $stmt->execute();

        // Delete dependent records
        $stmt = $conn->prepare('DELETE FROM berichten WHERE idchat IN (SELECT idchat FROM chat WHERE idadvertentie IN ('.$vraagtekensString.'))');
        $stmt->bind_param($typesString, ...$idAdvertentieArr);
        $stmt->execute();
        
        $stmt = $conn->prepare('DELETE FROM chat WHERE idadvertentie IN ('.$vraagtekensString.')');
        $stmt->bind_param($typesString,...$idAdvertentieArr);
        $stmt->execute();

        $stmt = $conn->prepare('DELETE FROM chat WHERE idadvertentie IN ('.$vraagtekensString.')');
        $stmt->bind_param($typesString,...$idAdvertentieArr);
        $stmt->execute();

        $stmt = $conn->prepare('DELETE FROM biedingen WHERE idadvertentie IN ('.$vraagtekensString.')');
        $stmt->bind_param($typesString,...$idAdvertentieArr);
        $stmt->execute();

        $stmt = $conn->prepare('DELETE FROM afbeeldingen WHERE idadvertentie IN ('.$vraagtekensString.')');
        $stmt->bind_param($typesString,...$idAdvertentieArr);
        $stmt->execute();

        $stmt = $conn->prepare('DELETE FROM advertentie WHERE idadvertentie IN ('.$vraagtekensString.')');
        $stmt->bind_param($typesString,...$idAdvertentieArr);
        $stmt->execute();
    }
}
?>