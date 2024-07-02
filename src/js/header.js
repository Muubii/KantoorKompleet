document.addEventListener("DOMContentLoaded", (event) =>{

    //als je op de profilebox klikt komt er een menu uit.
    const profilebox = document.querySelector(".user_acc");
    profilebox.onclick = function(){
        profilebox.classList.add("open");
    }
    let canProfileBoxClose;
    profilebox.onmouseenter = function(){
        canProfileBoxClose = false;
    }
    profilebox.onmouseleave = function(){
        canProfileBoxClose = true;
    }
    document.onclick = function(){
        if(profilebox.classList.contains("open") && canProfileBoxClose){
            profilebox.classList.remove("open");
        }
    }
    const profielOption = document.querySelector(".profiel");
    profielOption.onclick = function() {
        if(location.pathname != '/profiel.php'){
            location.href = "/profiel.php";
        }
    }
    const uitlogOption = document.querySelector(".uitloggen");
    uitlogOption.onclick = function() {

        xhr = new XMLHttpRequest()
        xhr.onload = function(){
            console.log(xhr.responseText)
            location.href = "/login.html";
        }
        xhr.open("POST", "php/deleteSessions.php");
        xhr.send();
    }
    const chatBtn = document.querySelector("#chatbtn");
    chatBtn.onclick = function(){
        window.location.href = "/chat.html";
    }
    const plaatsaddbtn = document.querySelector("#plaatsaddbtn");
    plaatsaddbtn.onclick = function(){
        window.location.href = "/plaatsadvertentie.php";
    }

})
