
function sendMessage() {
    let message = document.getElementById("message").value;
        //trim removed whitespace
    if (message.trim() === '') return;
    let isverkooper = document.getElementById('isverkooper').value;
    let idchat = document.getElementById('idchat').value;
    let xhr = new XMLHttpRequest();
    xhr.open('POST', 'database verzoeken/send_message.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {   
        // 4= req is compleet en alle data is er 200 = req success 
        if (xhr.readyState === 4 && xhr.status === 200) {
            document.getElementById("message").value = '';
            ophalenMessages();
        } else if (xhr.readyState === 4) {
            console.error('Error sending message:', xhr.status, xhr.statusText);
        }
    };
    //encodeURIComponent voorkomt dat data safe word gestuurd
    let data = `idchat=${idchat}&isverkooper=${isverkooper}&bericht=${encodeURIComponent(message)}`;
    xhr.send(data);
}

function ophalenMessages() {
    // let isverkooper = document.getElementById('isverkooper').value;
    let idchat = document.getElementById('idchat').value;
    let xhr = new XMLHttpRequest();
    xhr.open('GET', `database verzoeken/get_message.php?idchat=${idchat}`, true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            document.getElementById("chatBox").innerHTML = xhr.responseText;
        } else if (xhr.readyState === 4) {
            console.error('Error messages:', xhr.status, xhr.statusText);
        }
    };
    xhr.send();
}

setInterval(ophalenMessages, 1000); // refresh messages every second
ophalenMessages(); // Initial refresh

document.getElementById("send-btn").addEventListener("click", sendMessage);
document.getElementById("message").addEventListener("keypress", function(event) {
    if (event.key === "Enter") {
        sendMessage();
    }
});

