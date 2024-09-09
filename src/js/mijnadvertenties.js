const advertentiebox = document.querySelectorAll(".advertentiebox");
advertentiebox.forEach(advertentie => {
    advertentie.onclick = function () {
        let idadvertentie = advertentie.getAttribute('advertentieId');
        window.location.href = "/infoadvertentie.php?id=" + idadvertentie;
    }
})