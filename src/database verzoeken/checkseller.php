<?php
session_start();
include 'ConnDb.php';
$currentUser = $_SESSION ["idGebruiker"];
$idadvertentie = $_POST['advertentieId'];

if(!empty($idadvertentie) && isset ($idadvertentie)){
    $query1 ="SELECT idGebruiker FROM advertentie WHERE idadvertentie = $idadvertentie";

    $stmt = $conn->prepare($query1);
    $stmt -> execute();
    $result = $stmt->get_result()->fetch_assoc();
    $advertentieGebruiker = $result ["idGebruiker"];

    $response = [];

    // true = verkoper 
    if( $currentUser == $advertentieGebruiker ){
        $response ["isVerkoper"] = true;

    // else gebruiker kan chat aanmaken
    }else{
        $response ["isVerkoper"] = false;
        $response ["idgebruiker"] = $currentUser;

        $query2 = "SELECT chat.idchat FROM chat 
        INNER JOIN advertentie ON chat.idadvertentie = advertentie.idadvertentie
        WHERE advertentie.idadvertentie = ? AND chat.bieder = ?";
        
    $stmt2 = $conn->prepare($query2);
    $stmt2->bind_param("ii", $idadvertentie, $currentUser);
    $stmt2->execute();
    $chatExists = $stmt2->get_result()->fetch_assoc();
    
        if ($chatExists) {
            $response["chatExists"] = true;
            $response["chatId"] = $chatExists["idchat"];
            } else {
            $response["chatExists"] = false;
            }
        }
    }

$conn->close();
echo json_encode($response);
?>