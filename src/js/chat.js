var url_string = window.location.href;
var url = new URL(url_string);
var advertentieId = url.searchParams.get("id");
let bieder = 1;
let verkoperID = 0;
var chatExists;

function checkseller(){
    var xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
        // console.log("Raw response:", xhttp.responseText); // Log the raw response

    const response = JSON.parse(xhttp.responseText);

    chatExists = response["chatExists"];
    // console.log(chatExists); 
    

    let isVerkoper = response["isVerkoper"];
    verkoperID = response["idgebruiker"];
    let chatId = response["chatId"]; 
    verkoperID = response["idgebruiker"];
    if(isVerkoper){
        alert ("Je kan niet jezelf een bericht sturen.");
    }else{
        if (chatExists) {
            console.log(chatExists);
            
            console.log("chat exist" )
            window.location.href = `chat.php?idchat=${chatId}`;
        } else {
            createChat();
            console.log("chat does not exist")
        }
    }
};
    xhttp.open("POST", "database verzoeken/checkseller.php", true);
    
    xhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhttp.send("advertentieId="+advertentieId); 
}


function createChat() {
    var xhr = new XMLHttpRequest();

    xhr.onload = function() {
            if (xhr.status === 200) {
                var idchat = xhr.responseText;
                console.log('New chat created with ID:', idchat);
                // Redirect to the chat page
                window.location.href = `chat.php?idchat=${idchat}`; // Adjust the path if necessary
            } else {
                console.error('Error creating chat:', xhr.status, xhr.statusText);
            }
            console.log(xhr.responseText);
        }

        let data = {
            advertentieId: advertentieId,
            bieder: verkoperID
        };

        
        xhr.open("POST", "database verzoeken/createchat.php", true);
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.send(JSON.stringify(data)); 
        
    };
    

    

 