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
})


