<?php
include 'database verzoeken/ConnDb.php';
include 'php/checkSession.php';


$idchat = isset($_GET['idchat']) ? $conn->real_escape_string($_GET['idchat']) : '';
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
    <link rel="stylesheet" href="css/advertentie.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="js/header.js"></script>
</head>
<body>

    <header>
        <div class="headerContent">
            <div class="logoBox">
                <img src="images/logo.svg" alt="logoKantoorCompleet" class="logo" onclick="location.href='/'">
                <p class="logoTekst">Kantoor Compleet</p>
            </div>
            <nav class="headerNav">
                <button id="chatbtn"><img src="images/icons/chatIcon.svg" alt="icon" class="navIcon">Berichten</button>
                <button id="plaatsaddbtn"><img src="images/logoSmall.svg" alt="icon" class="navIcon">Nieuwe Advertentie</button>
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
        </div>
    </header>
    <main>
        <input id="menu__toggle" type="checkbox" />
        <label class="menu__btn" for="menu__toggle">
            <span></span>
        </label>
        <ul class="menu__box">
            <li><a class="menu__item" href="#">Richard</a></li>
            <li><a class="menu__item" href="#">Nina</a></li>
            <li><a class="menu__item" href="#">Anna</a></li>
            <li><a class="menu__item" href="#">Sam</a></li>
            <li><a class="menu__item" href="#">Mubi</a></li>
        </ul>

        <div class="chat-window">
            <div class="chat-header">Chat with <span id="chatWith">Sam</span></div>
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
</body>
</html>
