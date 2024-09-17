<?php
session_start();
include 'ConnDb.php';

$idchat = $_GET['idchat'];
$currentUserId = $_SESSION['idGebruiker'];

// details koper verkoper op te halen profielfoto's
$query = "SELECT gebruiker.Bedrijfsnaam as gebruikerNaam, 
                 gebruiker.logolocatie as biederFoto, 
                 chat.bieder, 
                 chat.idchat, 
                 chat.idadvertentie, 
                 advertentie.idGebruiker, 
                 gebruiker2.Bedrijfsnaam as verkoperNaam, 
                 gebruiker2.logolocatie as verkoperFoto
          FROM chat
          INNER JOIN gebruiker ON chat.bieder = gebruiker.idGebruiker
          INNER JOIN advertentie ON chat.idadvertentie = advertentie.idadvertentie
          INNER JOIN gebruiker as gebruiker2 ON advertentie.idGebruiker = gebruiker2.idGebruiker
          WHERE chat.idchat = ?";

// Bereid de query voor en voer het uit
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $idchat);
$stmt->execute();
$chatDetails = $stmt->get_result()->fetch_assoc();

if (!$chatDetails) {
    die();
}


// Haal de benodigde gegevens op
$buyerName = $chatDetails['gebruikerNaam'];
$sellerName = $chatDetails['verkoperNaam'];
$sellerId = $chatDetails['idGebruiker'];
$buyerId = $chatDetails['bieder'];

$buyerPhoto = $chatDetails['biederFoto'] ?? 'default.png';
$sellerPhoto = $chatDetails['verkoperFoto'] ?? 'default.png'; 

$sql = "SELECT * FROM berichten WHERE idchat = ? ORDER BY id";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $idchat);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Toon berichten
    while ($row = $result->fetch_assoc()) {
        $bericht = $row['bericht'] ?? ''; // Gebruik een lege string als 'bericht' null is

        // Bepaal wie het bericht heeft verzonden
        $isVerkooper = $row['isverkooper'];
        $senderName = $isVerkooper ? $sellerName : $buyerName;
        $senderPhoto = $isVerkooper ? $sellerPhoto : $buyerPhoto;  // Kies de juiste foto

        // Controleer of het bericht van de huidige gebruiker is
        $isCurrentUser = ($isVerkooper && $sellerId == $currentUserId) || (!$isVerkooper && $buyerId == $currentUserId);

        $bubbleClass = $isCurrentUser ? 'chat-bubble' : 'chat-bubble2';

        // Toon het bericht met de naam en foto van de afzender
        echo '<div class="' . $bubbleClass . '">
                <img src="afbeeldingenUsers/profielIcons/' . htmlspecialchars($senderPhoto, ENT_QUOTES, 'UTF-8') . '" alt="Profielfoto" class="profile-photo">
                <strong>' . htmlspecialchars($senderName, ENT_QUOTES, 'UTF-8') . ':</strong> ' . htmlspecialchars($bericht, ENT_QUOTES, 'UTF-8') . '
              </div>';
    }
}

$stmt->close();
$conn->close();
?>