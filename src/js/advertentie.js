function changeImage(src) {
    document.getElementById('main-image').src = src;
}


function createChat() {
    var idadvertentie = document.getElementById('idadvertentie').value;
    var bieder = document.getElementById('bieder').value;
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'database verzoeken/createchat.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    
    xhr.onload = function() {
        if (xhr.status === 200) {
            var idchat = xhr.responseText;
            console.log('New chat created with ID:', idchat);
        } else {
            console.error('Error creating chat:', xhr.status, xhr.statusText);
        }
    };

    xhr.onerror = function() {
        console.error('Request failed');
    };

    var data = 'idadvertentie=' + encodeURIComponent(idadvertentie) + '&bieder=' + encodeURIComponent(bieder);
    xhr.send(data);
}
