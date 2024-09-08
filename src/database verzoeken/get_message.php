<?php
session_start(); 

include 'ConnDb.php';

$idchat = $_GET['idchat'];
$currentUserId = $_SESSION['idGebruiker'];

$query = "SELECT gebruiker.Bedrijfsnaam as gebruikerNaam, chat.bieder, chat.idchat, chat.idadvertentie, 
                 advertentie.idGebruiker, gebruiker2.Bedrijfsnaam as verkoperNaam
          FROM chat
          INNER JOIN gebruiker ON chat.bieder = gebruiker.idGebruiker
          INNER JOIN advertentie ON chat.idadvertentie = advertentie.idadvertentie
          INNER JOIN gebruiker as gebruiker2 ON advertentie.idGebruiker = gebruiker2.idGebruiker
          WHERE chat.idchat = ?";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $idchat);
$stmt->execute();
$chatDetails = $stmt->get_result()->fetch_assoc();

$buyerName = $chatDetails['gebruikerNaam'];
$sellerName = $chatDetails['verkoperNaam'];
$sellerId = $chatDetails['idGebruiker'];
$buyerId = $chatDetails['bieder'];

// Haal chatberichten op
$sql = "SELECT * FROM berichten WHERE idchat = ? ORDER BY id";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $idchat);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $bericht = $row['bericht'] ?? ''; // Use an empty string if 'bericht' is null
    

    // Bepaal wie het bericht heeft verzonden
    $isVerkooper = $row['isverkooper'];
    $senderName = $isVerkooper ? $sellerName : $buyerName;

    // Controleer of het bericht van de huidige gebruiker is
    $isCurrentUser = ($isVerkooper && $sellerId == $currentUserId) || (!$isVerkooper && $buyerId == $currentUserId);


    $bubbleClass = $isCurrentUser ? 'chat-bubble' : 'chat-bubble2';

    // Toon het bericht met de naam van de afzender
    echo '<div class="' . $bubbleClass . '"><strong>' . htmlspecialchars($senderName, ENT_QUOTES, 'UTF-8') . ':</strong> ' . htmlspecialchars($bericht, ENT_QUOTES, 'UTF-8') . '</div>';
}
?>
