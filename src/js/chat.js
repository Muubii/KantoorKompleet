var url_string = window.location.href;
var url = new URL(url_string);
var advertentieId = url.searchParams.get("id"); // Haalt advertentieId van de URL
let verkoperID = 0;
var chatExists;

function checkseller(){
    var xhttp = new XMLHttpRequest();
    xhttp.onload = function() {

        const response = JSON.parse(xhttp.responseText);

        chatExists = response["chatExists"];
        let isVerkoper = response["isVerkoper"];
        verkoperID = response["idgebruiker"]; // zet the verkoperID

        let chatId = response["chatId"];
        
        if(isVerkoper){
            alert ("Je kan niet jezelf een bericht sturen.");
        } else {
            if (chatExists) {
                console.log("Chat exists, redirecting to chat page");
                window.location.href = `chat.php?idchat=${chatId}`;
            } else {
                console.log("Chat does not exist, creating new chat");
                createChat(verkoperID); // roept createChat met de correcte seller ID
            }
        }
    };

    xhttp.open("POST", "database verzoeken/checkseller.php", true);
    xhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhttp.send("advertentieId=" + advertentieId);  // stuurt the advertentieId naar de server
}

function startChat(biederId) {
    let advertentieId = url.searchParams.get("id");

    var xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
        const response = JSON.parse(xhttp.responseText);

        if (response.chatExists) {
            window.location.href = `chat.php?idchat=${response.chatId}`;
        } else {
            window.location.href = `chat.php?idchat=${response.chatId}`;
        }
    };
    
    xhttp.open("POST", "database verzoeken/createchat.php", true);
    xhttp.setRequestHeader('Content-Type', 'application/json');
    
    let data = {
        advertentieId: advertentieId,
        bieder: biederId
    };

    xhttp.send(JSON.stringify(data));
}


function createChat(biederId) {
    var xhr = new XMLHttpRequest();

    xhr.onload = function() {
        if (xhr.status === 200) {
            var idchat = xhr.responseText;
            console.log('New chat created with ID:', idchat);
            // Redirect to the new chat page
            window.location.href = `chat.php?idchat=${idchat}`;
        } else {
            console.error('Error creating chat:', xhr.status, xhr.statusText);
        }
    };

    let data = {
        advertentieId: advertentieId, 
        bieder: biederId  
    };

    xhr.open("POST", "database verzoeken/createchat.php", true);
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.send(JSON.stringify(data));  // stuurt de data als JSON
}
