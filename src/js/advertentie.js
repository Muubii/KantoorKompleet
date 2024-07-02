window.addEventListener("DOMContentLoaded", event =>{
    const mainImage = document.querySelector("#main-image");
    const allImages = document.querySelector(".thumbnails").querySelectorAll("img");
    console.log(allImages);
    mainImage.src = allImages[0].src;
    allImages.forEach(image =>{
        image.onclick = function(){
        mainImage.src = image.src;
    }
    });



    const plaatsBodBtn = document.querySelector("#plaatsBodBtn");
    plaatsBodBtn.onclick = function(){
        NieuwBod();
    }

HaalBiedingenOP();
// setInterval(HaalBiedingenOP, 2000);
function HaalBiedingenOP(){
    var url_string = window.location.href; 
    var url = new URL(url_string);
    var advertentieId = url.searchParams.get("id");

    let xhr = new XMLHttpRequest()
    xhr.onload = function(){
        biedingenBox.innerHTML = xhr.responseText;
    }
    xhr.open("POST", "database verzoeken/biedingenOphalen.php");
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send('advertentieid=' + advertentieId);
}

function NieuwBod(){
    const nieuwBod = document.querySelector("#inputBiedingBox").value;

    var url_string = window.location.href; 
    var url = new URL(url_string);
    var advertentieId = url.searchParams.get("id");

    let xhr = new XMLHttpRequest()
    xhr.onload = function(){
        console.log(xhr.responseText);
        HaalBiedingenOP();
    }
    xhr.open("POST", "database verzoeken/plaatsBod.php");
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send('advertentieid=' + advertentieId + '&prijs=' + nieuwBod);
}

})

