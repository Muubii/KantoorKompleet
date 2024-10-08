document.addEventListener('DOMContentLoaded', function() {

    const allImagesBox = document.querySelector(".allImagesBox");
    let firstImage = allImagesBox.firstElementChild.querySelector("img");
    const mainImage = document.querySelector(".mainImage")
    mainImage.src = firstImage.src;
    if(firstImage.height > firstImage.width){
        mainImage.style.height = "100%";
        mainImage.style.width = "auto";
    } else{
        mainImage.style.width = "100%";
        mainImage.style.height = "auto";
    }
    const allImages = Array.from(allImagesBox.querySelectorAll(".tile"));
    console.log(allImages)
    allImages.forEach(tile => {
        tile.onmouseenter = tile.ontoutch = function(){
            console.log("geklikt");
            const img = tile.querySelector('img');
            if(img){
                            mainImage.src = img.src;
            if(img.height > img.width){
                mainImage.style.height = "100%";
                mainImage.style.width = "auto";
            } else{
                mainImage.style.width = "100%";
                mainImage.style.height = "auto";
            }
            }

        }
    });
    

    const allChangeInfoBtns = document.querySelectorAll(".bewerkInfoBtn");
    allChangeInfoBtns.forEach(changeInfoBtn => {
        changeInfoBtn.onclick = function(){
            Array.from(document.querySelectorAll(".infoInput")).forEach(Input => {
                Input.classList.remove("activeInput");
                Input.disabled = true;

            });
            const InputNextToEditBtn = changeInfoBtn.parentElement.querySelector(".infoInput");
            InputNextToEditBtn.disabled = false
            InputNextToEditBtn.classList.add("activeInput");
            InputNextToEditBtn.focus();
        }
    });

    const deleteBtn = document.querySelector("#verwijderAdvertentieBtn");
    deleteBtn.onclick = function () {
        var url_string = window.location.href;
        var url = new URL(url_string);
        var advertentieId = url.searchParams.get("id");


        let xhr = new XMLHttpRequest();
        xhr.onload = function () {
            console.log(xhr.responseText);
            alert("advertentie succesvol verwijdert")
            window.location.href = "mijnadvertenties.php";
        }
        xhr.open('POST', 'database verzoeken/verwijderAdvertentie.php');
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send("id=" + advertentieId);
    }

    const updateBtn = document.querySelector("#UpdateAdvertentieBtn");
    updateBtn.onclick = function(){
        const advertentieInfo = new FormData();

        const advertentieNaam = document.querySelector("input[name='naamAdvertentie']").value;
        const prijs = document.querySelector("input[name='prijs']").value
        const biedenVanaf = document.querySelector("input[name='biedenVanaf']").value
        const verwijderdatum = document.querySelector("input[name='verwijderDatum']").value
        const beschrijving = document.querySelector("textarea[name='beschrijving']").value

        var url_string = window.location.href;
        var url = new URL(url_string);
        var idadvertentie = url.searchParams.get("id");

        const orderImages = {};
        const tiles = Array.from(document.querySelectorAll('.tile'));
        tiles.forEach(tile => {
            let image = tile.querySelector('.advertentieAfbeelding');
            if(image){
                let imageSrc = image.src;
                console.log(imageSrc)
                let imageName = imageSrc.split("/").pop();
                orderImages[imageName] = tile.style.order;
            }
        });

        advertentieInfo.append('id', idadvertentie);
        advertentieInfo.append('naam',advertentieNaam);
        advertentieInfo.append('prijs',prijs);
        advertentieInfo.append('biedenvanaf',biedenVanaf); 
        advertentieInfo.append('verwijderdatum',verwijderdatum);
        advertentieInfo.append('beschrijving',beschrijving);
        advertentieInfo.append('order', JSON.stringify(orderImages));
        

        xhr = new XMLHttpRequest()
        xhr.onload = function(){
            console.log(xhr.responseText);
            alert("Advertentie succesvol geupdate");
        }
        xhr.open("POST", "database verzoeken/updateAdvertentie.php")
        xhr.send(advertentieInfo)
    }
});