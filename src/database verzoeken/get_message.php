<?php
include 'ConnDb.php';

$idchat = $_GET['idchat'];

$sql = "SELECT * FROM berichten WHERE idchat = ? ORDER BY id";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $idchat);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $bericht = $row['bericht'] ?? ''; // Use an empty string if 'bericht' is null
    echo "<div><strong>" . ($row['isverkooper'] ? "Seller" : "Bieder") . ":</strong> " . htmlspecialchars($bericht, ENT_QUOTES, 'UTF-8') . "</div>";
}

$stmt->close();
$conn->close();
?>
