<?php
include 'ConnDb.php';

$idadvertentie = isset($_POST['idadvertentie']) ? $conn->real_escape_string($_POST['idadvertentie']) : '';
$bieder = isset($_POST['bieder']) ? $conn->real_escape_string($_POST['bieder']) : '';

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
