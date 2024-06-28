<?php
session_start();
require "ConnDb.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $target_dir = "../afbeeldingenUsers/";

    if(!empty($_FILES)){  
        $uploadOk = true;

        foreach($_FILES as $key => $file){
            print_r($file);
            $target_file = $target_dir . basename($file['name']);
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

            if(file_exists($target_file)){
                echo "het bestand bestaat al"; 
                $uploadOk = false;
            }

            // if($file['size'] > 1500000){
            //   echo "file is te groot";
            //   $uploadOk = false;
            // }
            

          if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
            echo "Sorry, only JPG, JPEG, PNG";
            $uploadOk = false;
          }

    }

      $required_fields= [
        'naam',
        'prijs',
        'bieden_vanaf',
        'automatische_verwijdering',
        'beschrijving',
        'categorieën',
      ];

      foreach ($required_fields as $field) {
        if (isset($_POST[$field])) {
          if($field != 'automatische_verwijdering'){
            if(empty($_POST[$field])){
              $uploadOk = false;
              echo $field . " is niet ingevuld" . "<br>";
            }
          }
        } else{
          $uploadOk = false;
        }
    }
    
    if (!$uploadOk) {
        echo "Geen geldige form";
    } else {
        echo "Formulier is correct ingevuld, verder verwerken...";
    }

    if($uploadOk){
      $imageNames = [];
        foreach($_FILES as $Key => $file){
          $target_file = $target_dir . basename($file['name']);
          $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
          $uniqName = uniqid();
          $imageNames[$file['name']] = $uniqName . "." .$imageFileType;
          $newfilename =  $uniqName . "." .$imageFileType;
          if (move_uploaded_file($file["tmp_name"], $target_dir . $newfilename)) {
            echo "Het bestand ". basename($file["name"]). " is geüpload.";
          }   
        }

        print_r($_POST);

        $idGebruiker = $_SESSION['idGebruiker'];
        $advertentie_naam = $_POST['naam'];
        $prijs = $_POST['prijs'];
        $bieden_vanaf = $_POST['bieden_vanaf'];
        $automatische_verwijdering = $_POST['automatische_verwijdering'];
        $beschrijving = $_POST['beschrijving'];


        //in de db staat de date altijd omgekeerd. drm dit 
        if(!empty($automatische_verwijdering)){
          $reverse_date = date("Y-m-d", strtotime($automatische_verwijdering));
        } else{
          $reverse_date = null;
        }

        $sql1 = "INSERT INTO advertentie (naam, prijs,biedenvanaf,automatischeverwijdering, beschrijving, idGebruiker) VALUES(?,?,?,?,?,?);";
        $stmt1 = $conn->prepare($sql1);
        $stmt1->bind_param("sddssi", $advertentie_naam, $prijs, $bieden_vanaf, $reverse_date, $beschrijving,$idGebruiker);
        $stmt1->execute();


        $id_advertentie = $conn->insert_id;
        // $afbeelding_locatie = 
        $orderImages = json_decode($_POST['order'], true);
        $allvaluesImages = "";

      $totalFiles = count($_FILES);
      $currentFileIndex = 0;
        foreach($_FILES as $file){
          if($currentFileIndex != $totalFiles -1){
            $str = "('" . $id_advertentie . "','" . $imageNames[$file['name']] . "','" . $orderImages[$file['name']] . "'),";

          } else{
            $str = "(" . $id_advertentie . ",'" . $imageNames[$file['name']] . "'," . $orderImages[$file['name']] . ")";

          }
          echo $file['name'];
          $allvaluesImages .= $str;
          $currentFileIndex++;
        }
        
        $sql2 = "INSERT INTO afbeeldingen (idadvertentie, afbeeldinglocatie,`order`) VALUES ".$allvaluesImages;
        $stmt2 = $conn->prepare($sql2);
        $stmt2->execute();


        // $id_categorie

        $allCategorieën = json_decode($_POST['categorieën']);
        $valuesCategorieën = "";
        $CategorieënNummer = 0;
        foreach($allCategorieën as $categorie){
          if($CategorieënNummer < count($allCategorieën) -1){
            $str = "(".$id_advertentie.",". $categorie."),";
          } else{
            $str = "(".$id_advertentie.",". $categorie.")";
          }
          $valuesCategorieën.=$str;
          $CategorieënNummer++;
        }
        $sql3 = "INSERT INTO advertentieCategorieën (idadvertentie, idcategorie) VALUES" . $valuesCategorieën;
        $stmt3 = $conn->prepare($sql3);
        $stmt3->execute();

    } else{
        echo "geen geldige bestanden";
        exit();
    }

    } else{
        echo "niet een voledige form";
        exit();
    }


    } else{
        echo "upload minimaal 1 bestand";
        exit();
    }
    
?>
