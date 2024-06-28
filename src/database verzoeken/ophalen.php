<?php
include 'ConnDb.php';

$chat_id = $_POST['chat_id'];
$buyer_id = $_POST['buyer_id'];

// Sanitize inputs
$chat_id = intval($chat_id);
$buyer_id = intval($buyer_id);

$sql = "SELECT b.idchat_bericht, g.Gebruikersnaam, b.bericht, b.isverkoper
        FROM berichten b
        JOIN chat c ON b.chat_idchat = c.idchat
        JOIN advertentie a ON c.advertentie_idadvertentie = a.idadvertentie
        JOIN gebruiker g ON (a.Gebruiker_idGebruiker = g.idGebruiker AND b.isverkoper = 1)
                          OR (b.isverkoper = 0 AND g.idGebruiker = ?)
        WHERE c.idchat = ?";

if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("ii", $buyer_id, $chat_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $messages = array();
        while ($row = $result->fetch_assoc()) {
            $messages[] = $row;
        }
        echo json_encode($messages);
    } else {
        echo json_encode([]);
    }
    $stmt->close();
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>
