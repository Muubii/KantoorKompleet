<?php
    session_start();
    require "ConnDb.php";

    $idGebruiker = $_SESSION['idGebruiker'];
    $idadvertentie = $_POST['advertentieid'];


    if (isset($idGebruiker, $idadvertentie, $_POST['prijs']) &&
    !empty($idGebruiker) && !empty($idadvertentie) && !empty($_POST['prijs'])){


    $sql = "SELECT idGebruiker
            FROM advertentie
            WHERE idadvertentie = $idadvertentie;";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $advertentieGebruikerId = $row['idGebruiker'];
    
    
    if($advertentieGebruikerId == $idGebruiker){
      echo "Same";
      exit();
    }
    $prijs = str_replace(',', '.', $_POST['prijs']);

    $stmt = $conn->prepare("INSERT INTO biedingen (idadvertentie, prijs, idGebruiker) VALUES (?, ?, ?)");
    $stmt->bind_param("idi", $idadvertentie, $prijs, $idGebruiker);
    $stmt->execute();
  }

?>
