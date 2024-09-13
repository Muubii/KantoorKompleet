<?php
include 'ConnDb.php';


$rawData = file_get_contents("php://input");

// Decode the JSON data into a PHP array
$data = json_decode($rawData, true);
print_r($data);

$idadvertentie = $data['advertentieId'];
$bieder = $data["bieder"]; 

$query1 ="SELECT idGebruiker FROM advertentie WHERE idadvertentie = $idadvertentie";

$query = "INSERT INTO chat (idadvertentie, bieder) VALUES (?, ?)";
$stmt = $conn->prepare($query);
if ($stmt === false) {
    die('Prepare failed: ' . $conn->error);
}

$stmt->bind_param('ii', $idadvertentie, $bieder);
if (!$stmt->execute()) {
    echo "Error in insertion: " . $stmt->error;
} else {
    echo $stmt->insert_id;  // Return the last inserted ID
}

$stmt->close();
$conn->close();
?>
