<?php
include 'ConnDb.php';

$chat_id = $_POST['chat_id'];
$isverkoper = $_POST['isverkoper'];
$bericht = $_POST['bericht'];

// beveiliging 
$chat_id = intval($chat_id);
$isverkoper = intval($isverkoper);
$bericht = $conn->real_escape_string($bericht);

$sql = "INSERT INTO berichten (chat_idchat, isverkoper, bericht) VALUES ('$chat_id', '$isverkoper', '$bericht')";
if ($conn->query($sql) === TRUE) {
    echo "Message sent successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
