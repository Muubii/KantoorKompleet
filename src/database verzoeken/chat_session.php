<?php
include "ConnDb.php";

$advertentie_id = $_POST['advertentie_id'];

//beveiliging
$advertentie_id = intval($advertentie_id);

$sql = "INSERT INTO chat (advertentie_idadvertentie) VALUES ('$advertentie_id')";
if ($conn->query($sql) === TRUE) {
    echo "New chat initiated successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
