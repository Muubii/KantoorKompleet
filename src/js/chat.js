document.getElementById('menu__toggle').addEventListener('change', function() {
    document.querySelector('.container').classList.toggle('menu-open', this.checked);
});

function sendMessage(chatId, isVerkoper, bericht) {
    if (!bericht) return;
    $('#chatBox').append(`<div class="chat-bubble">${bericht}</div>`); // Append user's message as a chat bubble

    $.ajax({
        url: 'send.php',
        type: 'POST',
        data: {
            chat_id: chatId,
            isverkoper: isVerkoper,
            bericht: bericht
        },
        success: function(response) {
            console.log(response);
            loadMessages(chatId); // Reload messages after sending
        }
    });
}

function loadMessages(chatId) {
    $.ajax({
        url: 'ophalen.php',
        type: 'POST',
        data: { chat_id: chatId },
        success: function(response) {
            let messages = JSON.parse(response);
            let messageContainer = $('#chatBox');
            messageContainer.html('');
            messages.forEach(function(message) {
                let messageClass = message.isverkoper ? 'chat-bubble2' : 'chat-bubble';
                messageContainer.append(`<div class="${messageClass}">${message.Gebruikersnaam}: ${message.bericht}</div>`);
            });
        }
    });
}

$(document).ready(function() {
    let chatId = 1; // Assume chat ID 1 for this example
    loadMessages(chatId); // Load messages for chat with ID 1

    $('#send-btn').on('click', function() {
        let bericht = $('#message').val().trim();
        sendMessage(chatId, 0, bericht); // Assume isVerkoper = 0 for the user
        $('#message').val(''); // Clear input field after sending
    });

    $('#message').on('keypress', function(e) {
        if (e.which === 13) { // Enter key pressed
            let bericht = $(this).val().trim();
            sendMessage(chatId, 0, bericht); // Assume isVerkoper = 0 for the user
            $(this).val(''); // Clear input field after sending
        }
    });
});