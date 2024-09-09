const advertentiebox = document.querySelectorAll(".advertentiebox");
advertentiebox.forEach(advertentie => {
    advertentie.onclick = function () {
        let idadvertentie = advertentie.getAttribute('data-advertentieId');
        window.location.href = "/infoadvertentie.php?id=" + idadvertentie;
    }
})


const verwijderVerwijderdeAdvertentieBtn = document.querySelector("#verwijderVerwijderdeAdvertentieBtn");
if(verwijderVerwijderdeAdvertentieBtn){
    verwijderVerwijderdeAdvertentieBtn.onclick = function(){
    const xhr = new XMLHttpRequest();
    xhr.onload = function(){
        alert("oude advertenties verwijdert");
        location.reload();
    }
    xhr.open("POST", "database verzoeken/verwijderOudeAdvertenties.php");
    xhr.send();
}
}
