const advertentiebox = document.querySelector(".advertentieBox");

SelectCategorieën()
function SelectCategorieën() {
    let xhr = new XMLHttpRequest();
    xhr.onload = function () {
        categorieënInput.innerHTML += xhr.responseText;
    }
    xhr.open("POST", "database verzoeken/selectCategorieën.php")
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send("voorselectInput=true");
}

const filterform = document.querySelector("#filteradvertenties");

filterform.addEventListener("submit", function (event) {
    event.preventDefault();
    const formData = new FormData(this);
    console.log(formData)
    var xhr = new XMLHttpRequest();
    xhr.onload = function () {
        advertentiebox.innerHTML = xhr.responseText;
        gaNaarAdvertentie()
    }
    xhr.open("POST", "database verzoeken/zoekadvertenties.php")
    xhr.send(formData);
});
function gaNaarAdvertentie() {
    let advertenties = document.querySelectorAll(".advertentie");
    advertenties.forEach(advertentie => {
        advertentie.onclick = function () {
            let idadvertentie = advertentie.getAttribute('advertentieId');
            window.location.href = "/advertentie.php?id=" + idadvertentie;
        }
    });
}

const filterIconBtn = document.querySelector(".filtericon");
const extrafilters = document.querySelector(".extraFilters");
const bottomOfGrid = document.querySelector(".bottomOfGrid");
const topOfGrid = document.querySelector(".topOfGrid");

function updateFiltersPosition() {
    if (window.innerWidth > 800) {
        var secondChild = topOfGrid.children[2];

        topOfGrid.insertBefore(extrafilters, secondChild);
        extrafilters.classList.remove("verticaalFilters");
    }
}
window.addEventListener('resize', updateFiltersPosition);
updateFiltersPosition();

filterIconBtn.onclick = function () {
    extrafilters.classList.toggle("verticaalFilters");
    bottomOfGrid.appendChild(extrafilters);
};
