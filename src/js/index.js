window.addEventListener("DOMContentLoaded", function (event) {
    const advertentieBox = document.querySelector(".advertentieBox");


    tekenAdvertenties();

    function tekenAdvertenties() {
        const xhr = new XMLHttpRequest();
        xhr.onload = function () {
            advertentieBox.innerHTML = xhr.responseText;
            gaNaarAdvertentie()
        }
        xhr.open("POST", "database verzoeken/zoekadvertenties.php");
        xhr.send();
    }


    function gaNaarAdvertentie() {
        let advertenties = document.querySelectorAll(".advertentie");
        advertenties.forEach(advertentie => {
            advertentie.onclick = function () {
                let idadvertentie = advertentie.getAttribute('advertentieId');
                window.location.href = "/advertentie.php?id=" + idadvertentie;
            }
        });
    }
});