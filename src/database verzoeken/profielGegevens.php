<?php
    session_start();
    require 'ConnDb.php';
    $idgebruiker = $_SESSION['idGebruiker'];
    print_r($_FILES);

    if(isset($_FILES['Logo']) && !empty($_FILES['Logo'] ) && $_FILES['Logo']['error'] === 0){
        
        $logo = $_FILES['Logo'];
        $target_dir = "../afbeeldingenUsers/profielIcons/";

        $target_file = $target_dir . basename($logo['name']);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        if (file_exists($target_file)) {
            echo "Sorry probeer het opnieuw";
            exit();
        }

        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
            echo "Sorry, alleen JPG, JPEG, PNG zijn toegestaan";
            exit();
        }


        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $uniqName = uniqid();
        $logo['name'] = $uniqName . "." . $imageFileType;
        $newfilename = $uniqName . "." . $imageFileType;
        if(move_uploaded_file($logo["tmp_name"], $target_dir . $newfilename)){
            echo "het bestand is geupload";
        } else{
        echo "het is niet gelukt";
        exit();
        }
    }



    $websiteURL = $_POST['WebsiteURL'];
    $locatie = $_POST['Locatie'];
    $mail = $_POST['Mail'];
    $telefoon = $_POST['Telefoon'];

        echo "hoi";
    echo $websiteURL;
    echo $locatie;
    echo $mail;
    echo $telefoon;


if(isset($_FILES['Logo'])){
    $stmt = $conn->prepare("UPDATE gebruiker
                            SET logolocatie = ?, websitelink = ?, bedrijfslocatie = ?, mail = ?, telefoon = ?
                            WHERE idGebruiker = ?
                          ");
                          
    $stmt->bind_param("sssssi", $newfilename ,$websiteURL, $locatie, $mail, $telefoon, $idgebruiker);
    $stmt->execute();

} else{
    $stmt = $conn->prepare("UPDATE gebruiker
                            SET websitelink = ?, bedrijfslocatie = ?, mail = ?, telefoon = ?
                            WHERE idGebruiker = ?
                          ");
                          
    $stmt->bind_param("ssssi" ,$websiteURL, $locatie, $mail, $telefoon, $idgebruiker);
    $stmt->execute();
}

echo "het is gelukt";



?>