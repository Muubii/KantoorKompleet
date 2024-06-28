// Upload the images -------------------------------------------------------------

const imageInput = document.getElementById("uploadFile");
let images = [];
const tiles = document.querySelectorAll(".tile");
let AllFiles = [];
imageInput.addEventListener("change", (event) => {
    const files = event.target.files;
    for (const file of files) {    
    if(file){
        const allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;
        if (!allowedExtensions.exec(file.name)) {
            alert('Alleen bestanden van .jpeg/.jpg/.png toegestaan.');
            return false;
        }
    }
        AllFiles.push(file);
        AllFiles = AllFiles.slice(0, 10);
        const reader = new FileReader();

        reader.onload = (e) => {
            const img = document.createElement("img");
            img.classList.add("advertentieImg");
            img.src = e.target.result;
            img.filename = file.name;
            images.push(img);

            // Place images in tiles and update tilesWithImages
            PlaceImagesFromArrayInTile();
            DeleteImageFromTile();
        };

        reader.readAsDataURL(file);
    }
});

function clearAllDeleteButtons() {
    tiles.forEach(tile => {
        const deleteBtn = tile.querySelector(".deleteBtn");
        const gradient = tile.querySelector(".gradient");
        if (deleteBtn) deleteBtn.remove();
        if (gradient) gradient.remove();
    });
}

function DeleteImageFromTile() {
    tiles.forEach(tile => {
        tile.onmouseenter = tile.ontouchstart = function() {
            clearAllDeleteButtons(); // Clear delete buttons from all tiles

            const image = tile.querySelector("img");
            if (image) {
                const deleteBtn = document.createElement("button");
                const gradient = document.createElement("div");
                deleteBtn.classList.add("deleteBtn");
                gradient.classList.add("gradient");

                deleteBtn.innerHTML = "<img alt='Icon' src='images/icons/deleteicon.svg'>";

                tile.appendChild(gradient);
                tile.appendChild(deleteBtn);

                deleteBtn.onclick = deleteBtn.ontouchstart = function() {
                    deleteBtn.remove();
                    gradient.remove();
                    let index = images.indexOf(image);
                    console.log(index);
                    for(let i = 0; i < AllFiles.length; i++){
                        if(images[index].filename === AllFiles[i].name){
                            AllFiles.splice(i, 1);
                        }
                    }
                    images.splice(index, 1);
                    image.remove();
                    PlaceImagesFromArrayInTile();
                };
            }
        };

        tile.onmouseleave = function() {
            const deleteBtn = tile.querySelector(".deleteBtn");
            const gradient = tile.querySelector(".gradient");
            if (deleteBtn) deleteBtn.remove();
            if (gradient) gradient.remove();
        };
    });
}

function PlaceImagesFromArrayInTile() {
    // Sort the tiles based on the 'order' style property
    let sortedTiles = Array.from(tiles).sort((a, b) => {
        let orderA = parseInt(a.style.order) || 0;
        let orderB = parseInt(b.style.order) || 0;
        return orderA - orderB;
    });

    // Place the images in the sorted tiles
    for (let i = 0; i < sortedTiles.length; i++) {
        const tile = sortedTiles[i];
        if (images[i] !== undefined) {
            tile.appendChild(images[i]);
        }
    }
}

const categorieënBox = document.querySelector(".categoriënbox");
const arrow = document.querySelector(".arrowIcon");
let boxisopen = false;
function bekijkCategorien(){
    arrow.parentNode.onclick = function(){
        if (boxisopen){
            boxisopen = false
            categorieënBox.classList.add("categoriënboxopen");
            arrow.classList.add("animation")
        } else{
            boxisopen = true;
            categorieënBox.classList.remove("categoriënboxopen");
            arrow.classList.remove("animation")
        }
    }
}
categorieënFromDatabase();
function categorieënFromDatabase(){
xhr = new XMLHttpRequest()
xhr.onload = function(){
    document.getElementById("categorieënbox").innerHTML = xhr.responseText;
    SelectCategorieën();
}

xhr.open('POST', 'database verzoeken/selectCategorieën.php', true);
xhr.send();

}


function SelectCategorieën(){
    let alleCategorieën = [...document.querySelector(".categoriënbox").children];
    let allecategorieënBox = document.querySelector(".categoriënbox");
    let selectedCategorienBox = document.querySelector(".selectedCategorieën");


    alleCategorieën.forEach(categorie => {
        categorie.onclick = function(){
            if(categorie.parentElement == allecategorieënBox){
                selectedCategorienBox.appendChild(categorie)
            } else{
                allecategorieënBox.appendChild(categorie)
            }
        }
    });    
}




//-------------------------------------------------------------------------------------------------
//plaats advertentie in database. -
const advertentieform = document.getElementById("advertentiegegevens");
const submitAdvertentieform = document.getElementById("submitBtn");

advertentieform.addEventListener("submit", function(event) {
    event.preventDefault();
    const formData = new FormData(event.target);
    const files = Array.from(AllFiles.slice(0, 10));
    orderArr = {};


    if (files.length < 1) {
        alert("Upload minstens 1 afbeelding");
        return;
    }
    let iterations = images.length >= 10 ? 10 : images.length;
    for(let i = 0;  i < iterations; i++){
        for(let j = 0; j < AllFiles.length; j++){
            if(images[i].filename == AllFiles[j].name){
                orderArr[AllFiles[j].name] = window.getComputedStyle(images[i].parentNode).order;
            }
        }
    }

    let selectedCategorieën = Array.from(document.querySelector(".selectedCategorieën").querySelectorAll("div")).map(element => element.getAttribute('categorieid'));
    files.forEach((file, index) => {
        const reader = new FileReader();
        reader.onload = function(event) {
            const fileContent = event.target.result;
            formData.append(`Image${index}`, new Blob([fileContent], { type: file.type }), file.name);
            if((index) === files.length - 1){

                formData.append('categorieën', JSON.stringify(selectedCategorieën));
                formData.append('order', JSON.stringify(orderArr));
                const xhr = new XMLHttpRequest();
                xhr.onload = function() {
                    console.log(xhr.responseText);
                };
                
                xhr.open("POST", "database verzoeken/plaatsadvertentie.php", true);
                xhr.send(formData);
            }
        };
        reader.readAsArrayBuffer(file);
    });
});


