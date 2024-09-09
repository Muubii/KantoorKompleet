<?php
session_start();
include 'ConnDb.php';

$idgebruiker = $_SESSION['idGebruiker'];

$sql = "SELECT logolocatie, Bedrijfsnaam FROM gebruiker WHERE idgebruiker = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $idgebruiker);

$stmt->execute();
$result = $stmt->get_result();

$response = [];
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $response['logolocatie'] = $row['logolocatie'];
    $response['Bedrijfsnaam'] = $row['Bedrijfsnaam'];

}
$stmt->close();
$conn->close();

echo json_encode($response);
?>