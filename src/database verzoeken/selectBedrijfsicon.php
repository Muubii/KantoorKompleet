<?php
session_start();
include 'ConnDb.php';

$idgebruiker = $_SESSION['idGebruiker'];

$sql = "SELECT logolocatie FROM gebruiker WHERE idgebruiker = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $idgebruiker);

$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $logolocatie = $row['logolocatie'];
    echo $logolocatie;
}
$stmt->close();
$conn->close();
?>