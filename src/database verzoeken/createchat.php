<?php
include 'ConnDb.php';

// Vangt de raw JSON data en stuurt in de request
$rawData = file_get_contents("php://input");

// Decode de JSON data in een php array
$data = json_decode($rawData, true);

$idadvertentie = $data['advertentieId'];
$bieder = $data['bieder'];

//Checkt als de chat tussen de verkoper en bieder al bestaat voor deze advertentie
$queryCheckChat = "SELECT idchat FROM chat WHERE idadvertentie = ? AND bieder = ?";
$stmtCheckChat = $conn->prepare($queryCheckChat);
$stmtCheckChat->bind_param('ii', $idadvertentie, $bieder);
$stmtCheckChat->execute();
$resultCheckChat = $stmtCheckChat->get_result();

if ($resultCheckChat->num_rows > 0) {
    // Als de chat bestaat, return de bestaande chat id 
    $row = $resultCheckChat->fetch_assoc();
    echo json_encode(['chatExists' => true, 'chatId' => $row['idchat']]);
    exit();
}

//Ceeck als de bieder bestaat in de gebruiker tabel zodat de fk bestaat
$queryCheckBieder = "SELECT idGebruiker FROM gebruiker WHERE idGebruiker = ?";
$stmtCheckBieder = $conn->prepare($queryCheckBieder);
$stmtCheckBieder->bind_param('i', $bieder);
$stmtCheckBieder->execute();
$resultCheckBieder = $stmtCheckBieder->get_result();

if ($resultCheckBieder->num_rows === 0) {
    // If bieder does not exist, return an error
    die('Error: bieder does not exist in gebruiker table');
}

// Proceed with inserting into chat table if bieder exists
$queryInsert = "INSERT INTO chat (idadvertentie, bieder) VALUES (?, ?)";
$stmtInsert = $conn->prepare($queryInsert);
if ($stmtInsert === false) {
    die('Prepare failed: ' . $conn->error);
}

// Bind the parameters and execute the insert query
$stmtInsert->bind_param('ii', $idadvertentie, $bieder);
if (!$stmtInsert->execute()) {
    echo "Error in insertion: " . $stmtInsert->error;
} else {
    // Return the new chat ID
    echo json_encode(['chatExists' => false, 'chatId' => $stmtInsert->insert_id]);
}

$stmtCheckChat->close();
$stmtCheckBieder->close();
$stmtInsert->close();
$conn->close();
?>
