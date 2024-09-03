<?php
include 'database verzoeken/ConnDb.php';
include 'php/checkSession.php';

$idchat = isset($_GET['idchat']) ? $conn->real_escape_string($_GET['idchat']) : '';
$currentUserId = $_SESSION['idGebruiker'];

// cheken als deze gebruiker in de chat is
$query = "SELECT advertentie.idGebruiker, chat.bieder
          FROM chat 
          INNER JOIN advertentie ON chat.idadvertentie = advertentie.idadvertentie 
          WHERE chat.idchat = ? AND (advertentie.idGebruiker = ? OR chat.bieder = ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param('iii', $idchat, $currentUserId, $currentUserId);
$stmt->execute();
$stmt->store_result();



$stmt->close();

// gebruiker of verkoper 
$isverkooper = ($_SESSION['idGebruiker'] == get_advertentie_owner($idchat, $conn)) ? 1 : 0;

function get_advertentie_owner($idchat, $conn) {
    $query = "SELECT advertentie.idGebruiker 
              FROM chat 
              INNER JOIN advertentie ON chat.idadvertentie = advertentie.idadvertentie 
              WHERE chat.idchat = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $idchat);
    $stmt->execute();
    $stmt->bind_result($owner_id);
    $stmt->fetch();
    $stmt->close();
    return $owner_id;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat System</title>
    <link rel="stylesheet" href="css/chat.css">
    <link rel="icon" href="images/logoSmall.svg" type="image/icon type">
        <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<header>
        <div class="headerContent">
            <div class="logoBox">
                <img src="images/logo.svg" alt="logoKantoorCompleet" class="logo" onclick="location.href='/'">
                <p class="logoTekst">Kantoor Compleet</p>
            </div>

            <nav class="headerNav">
                <button id="hamburgerMenu"><img src="images/icons/hamburgericon.svg" class="icon" alt="icon"></button>
                <button id="chatbtn" class="navBtn btnIcon"><img src="images/icons/chatIcon.svg" alt="icon" class="icon">Berichten</button>
                <button id="plaatsaddbtn" class="navBtn btnIcon"><img src="images/logoSmall.svg" alt="icon" class="icon">Nieuwe advertentie</button>
                <button id="mijnaddbtn" class="navBtn btnIcon"><img src="images/icons/mijnadvertentiesicon.svg" alt="icon" class="icon">Mijn advertenties</button>
                <div class="user_acc">
                    <div class="usericonbox"><img src="images/icons/personIcon.svg" class="personIcon"></div>
                    <div class="usermenubox">
                        <ul class="listUserOptions">
                            <li class="useroption profiel">Profiel</li>
                            <li class="useroption uitloggen">Uitloggen</li>
                        </ul>
                    </div>
                </div>
            </nav>

            <form class="filter" id="filteradvertenties">
                <div class="topOfGrid">
                    <button class="filtericon" type="button"><img src="images\icons\filtericon.svg" alt="icon" class="icon"></button>
                    <input type="text" placeholder="Zoeken" id="zoekInput" name="zoekInput">
                    <div class="extraFilters">
                        <select id="categorieënInput" name="categorieënInput">
                        <option value="0">alle categorieën</option>
                        </select>
                        <input type="text" placeholder="van" id="vanPrijsInput" class="geldInput" name="vanPrijsInput">
                        <input type="text" placeholder="tot" id="totPrijsInput" class="geldInput" name="totPrijsInput">
                    </div>

                <button type="submit" class="btnIcon"><img src="images/icons/zoekicon.svg" class="icon">zoeken</button>
                </div>
                <div class="bottomOfGrid"></div>
            </form>

        </div>
    </header>

    <main>
      
        <label class="menu__btn" for="menu__toggle">
            <span></span>
        </label>
        <ul class="menu__box">
            <!-- je bedrijfsnaam -->
            <?php
$query = "SELECT gebruiker.Bedrijfsnaam, chat.bieder, chat.idchat, chat.idadvertentie
          FROM chat
          INNER JOIN gebruiker ON chat.bieder = gebruiker.idGebruiker
          INNER JOIN advertentie ON chat.idadvertentie = advertentie.idadvertentie
          WHERE chat.bieder = ? OR advertentie.idGebruiker = ?";

$stmt = $conn->prepare($query);
$currentUserId = $_SESSION['idGebruiker'];
$stmt->bind_param('ii', $currentUserId, $currentUserId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $biederId = $row["bieder"];
        $biederBedrijfsnaam = $row["Bedrijfsnaam"];
        $idChat = $row["idchat"];
        echo "<li><a class='menu__item' href='chat.php?idchat=$idChat'>$biederBedrijfsnaam</a></li>";
    }
}
$stmt->close();
?>
        </ul>

        <div class="chat-window">
            <div class="chat-header">Chat with <span id="chatWith"><?php echo $biederBedrijfsnaam;?></span></div>
            <div class="chat-content">
                <div id="chatBox"></div>
            </div>

            <div class="chat-input">
                <input type="hidden" id="idchat" value="<?php echo $idchat; ?>">
                <input type="hidden" id="isverkooper" value="<?php echo $isverkooper; ?>">
                <input type="text" id="message" placeholder="Enter your message">
                <button id="send-btn" class="button">Send</button>
            </div>
        </div>

    </main>

<script src="js/chat.js"></script>
<script src="js/header.js"></script>
</body>
</html>
