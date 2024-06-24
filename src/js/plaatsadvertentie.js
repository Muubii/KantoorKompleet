// Upload the images -------------------------------------------------------------
const imageInput = document.getElementById("uploadFile");
let images = [];
const tiles = document.querySelectorAll(".tile");

imageInput.addEventListener("change", (event) => {
    const files = event.target.files;

    for (const file of files) {
        const reader = new FileReader();

        reader.onload = (e) => {
            const img = document.createElement("img");
            img.classList.add("advertentieImg");
            img.src = e.target.result;
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
                    images.splice(images.indexOf(image), 1);
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
SelectCategorieën();
function SelectCategorieën(){
    let alleCategorieën = Array.from(categorieënBox.children);
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
