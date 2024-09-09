<?php
    session_start();
    require 'ConnDb.php';

    $idGebruiker = $_SESSION['idGebruiker'];

    if(isset($_POST['id']) && !empty($_POST['id']) && $idGebruiker){
        $idAdvertentie = $_POST['id'];

        $stmt = $conn->prepare('SELECT afbeeldinglocatie from afbeeldingen WHERE idadvertentie = ?');
        $stmt->execute([$idAdvertentie]);
        $result = $stmt->get_result();
        while($row = $result->fetch_assoc()){
        foreach($row as $filename){
            if (file_exists("../afbeeldingenUsers/". $filename)) {
                if(unlink("../afbeeldingenUsers/". $filename)){
                    echo "afbeeldingen verwijdert";
                }else{
                    echo "kon afbeeldingen niet verwijderen";
                }
            } else {
                echo 'Could not delete '.$filename.', file does not exist';
            }    
            }
        }






        $stmt = $conn->prepare('DELETE FROM advertentieCategorieën WHERE idadvertentie = ?');
        $stmt->execute([$idAdvertentie]);

        $stmt = $conn->prepare('DELETE FROM berichten WHERE idchat IN (SELECT idchat FROM chat WHERE idadvertentie = ?)');
        $stmt->execute([$idAdvertentie]);

        $stmt = $conn->prepare('DELETE FROM chat WHERE idadvertentie = ?');
        $stmt->execute([$idAdvertentie]);

        $stmt = $conn->prepare('DELETE FROM biedingen WHERE idadvertentie = ?');
        $stmt->execute([$idAdvertentie]);

        $stmt = $conn->prepare('DELETE FROM afbeeldingen WHERE idadvertentie = ?');
        $stmt->execute([$idAdvertentie]);

        $stmt = $conn->prepare('DELETE FROM advertentie WHERE idadvertentie = ?');
        $stmt->execute([$idAdvertentie]);

        $result = $stmt->get_result();
    }  
?>