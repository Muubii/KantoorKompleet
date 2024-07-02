document.getElementById('menu__toggle').addEventListener('change', function() {
    document.querySelector('.container').classList.toggle('menu-open', this.checked);
});

let idchat = 1;
let isverkooper = 1;

function ophalenMessages() {
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

function sendMessage() {
    let message = document.getElementById("message").value;
    if (message.trim() === '') return;

    let xhr = new XMLHttpRequest();
    xhr.open('POST', 'database verzoeken/send_message.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {   
        if (xhr.readyState === 4 && xhr.status === 200) {
            document.getElementById("message").value = '';
            ophalenMessages();
        } else if (xhr.readyState === 4) {
            console.error('Error sending message:', xhr.status, xhr.statusText);
        }
    };
    let data = `idchat=${idchat}&isverkooper=${isverkooper}&bericht=${encodeURIComponent(message)}`;
    xhr.send(data);
}

setInterval(ophalenMessages, 1000); // refresh messages every second
ophalenMessages(); // Initial refresh

document.getElementById("send-btn").addEventListener("click", sendMessage);
document.getElementById("message").addEventListener("keypress", function(event) {
    if (event.key === "Enter") {
        sendMessage();
    }
});
