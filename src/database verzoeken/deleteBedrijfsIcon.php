<?php
    session_start();
    require 'ConnDb.php';
    $idGebruiker = $_SESSION['idGebruiker'];
    echo $idGebruiker;
    $stmt = $conn->prepare('SELECT logolocatie FROM gebruiker WHERE idGebruiker = ?');
    $stmt->bind_param('i', $idGebruiker);
    $stmt->execute();

    $result = $stmt->get_result();
    if($result->num_rows > 0){
        $row = $result->fetch_assoc();
        $filename = $row['logolocatie'];



        $stmt = $conn->prepare('UPDATE gebruiker 
                                SET logolocatie = NULL
                                WHERE idGebruiker=?');
        $stmt->bind_param("i", $idGebruiker);
        echo "afbeelding suc6vol verwijd";
        $stmt->execute();


        if (file_exists("../afbeeldingenUsers/profielIcons/". $filename)) {
            unlink("../afbeeldingenUsers/profielIcons/". $filename);
          } else {
            echo 'Could not delete '.$filename.', file does not exist';
          }


    } else{
        echo "geen resultaten gevonden";
        exit();
    }










?>