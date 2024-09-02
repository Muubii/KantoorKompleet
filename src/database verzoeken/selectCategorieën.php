<?php
require 'ConnDb.php'; // Zorg ervoor dat ConnDb.php de databaseverbinding initialiseert

$isvoorselect = false;
if (isset($_POST['voorselectInput']) && $_POST['voorselectInput'] === 'true') {
    $isvoorselect = true;
}

$stmt = $conn->prepare('SELECT * FROM categorie');
$stmt->execute();
$result = $stmt->get_result(); // Gebruik get_result() om het resultaatset op te halen

// Controleer of er rijen zijn teruggegeven
if ($result->num_rows > 0) {
    // Loop door elke rij in het resultaat
    if($isvoorselect){
        while ($row = $result->fetch_assoc()) {
            echo "<option value=". $row['idcategorie'] .">".$row['naam']."</option>";
        }
    }else{
        while ($row = $result->fetch_assoc()) {
            echo "<div categorieid=". $row['idcategorie'] .">".$row['naam']."</div>";
        }
    }

} else {
    echo "Geen categorieën gevonden.";
}   

$stmt->close(); // Sluit de statement

// Sluit de databaseverbinding als deze niet meer nodig is
$conn->close();
?>
