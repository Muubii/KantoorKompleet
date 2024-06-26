<?php
session_start();
require "ConnDb.php";

if(!empty($_FILES)){
    $target_dir = "/afbeeldingenUser";
    $uploadOk = true;
    foreach($_FILES as $key => $file){
        print_r($file);
        $target_file = $target_dir . basename($file['name']);
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        if(file_exists($target_file)){
            echo "het bestand bestaat al";
            $uploadOk = false;
        }

        if($file['size'] > 1500000){
          echo "file is te groot";
          $uploadOk = false;
        }







    }


} else{
    echo "upload minimaal 1 bestand";
    exit();
}



// print_r($_FILES);
// $totalFiles = count($_FILES); //nummer Array bijv 3Array

// echo "TOtal files = ". $totalFiles;
// print_r($_POST);





      $sql1 = "INSERT INTO advertentie (naam, prijs,biedenvanaf,automatischeverwijdering, beschrijving";
      $sql2 = "INSERT INTO afbeeldingen (advertentie_idadvertentie, afbeeldinglocatie)";
      $sql3 = "INSERT INTO categorieën-advertentie (advertentie_idadvertentie, categorie_idcategorie)";
      echo "Yeaaaaa";
      if(isset($_SESSION['username'])){
        echo $_SESSION['username'];
      }




?>
