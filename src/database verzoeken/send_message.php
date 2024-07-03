<?php
include 'ConnDb.php';

$idchat = $_POST['idchat'];
$isverkooper = $_POST['isverkooper'];
$bericht = $_POST['bericht'];

$sql = "INSERT INTO berichten (idchat, isverkooper, bericht) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iis", $idchat, $isverkooper, $bericht);

if ($stmt->execute()) {
    echo "Message sent successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$stmt->close();
$conn->close();
?>