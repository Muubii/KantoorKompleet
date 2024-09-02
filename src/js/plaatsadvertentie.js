// Upload the images -------------------------------------------------------------
var dateInputs = document.querySelectorAll("input[type='datetime-local']");
var now = new Date();

var minDateTime = now.toISOString().slice(0, 16);

dateInputs.forEach(function (input) {
    input.setAttribute('min', minDateTime);
});


const maxfilesize = 7 * 1024 * 1024; // 7MB
const imageInput = document.getElementById("uploadFile");
const tiles = document.querySelectorAll(".tile");

let AllFiles = [];  //zijn afbeeldingen qua data
let images = []; //zijn afbeeldingen in de dom


imageInput.addEventListener("change", (event) => {
    const files = Array.from(event.target.files);
    let canUpload = true;
    for (let file of files) {
        console.log(file)
        if (file) {
            const allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;
            if (!allowedExtensions.exec(file.name)) {
                alert('Alleen bestanden van .jpeg/.jpg/.png toegestaan.');
                imageInput.value = "";
                canUpload = false;
                break;

            }
        }

        if (file.size > maxfilesize) {
            alert('Maximaal bestanden van ' + maxfilesize / 1024 / 1024 + 'MB');
            imageInput.value = "";
            canUpload = false;
            break;
        }
    }
    if (canUpload) {
        files.forEach(file => {
            AllFiles.push(file);
            const reader = new FileReader();
            reader.onload = (e) => {
                const img = document.createElement("img");
                img.classList.add("advertentieImg");
                img.src = e.target.result;
                img.filename = file.name;
                images.push(img);

                PlaceImagesFromArrayInTile();
                DeleteImageFromTile();
            };

            reader.readAsDataURL(file);
        });
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
        tile.onmouseenter = tile.ontouchstart = function () {
            clearAllDeleteButtons();

            const image = tile.querySelector("img");
            if (image) {
                const deleteBtn = document.createElement("button");
                const gradient = document.createElement("div");
                deleteBtn.classList.add("deleteBtn");
                gradient.classList.add("gradient");

                deleteBtn.innerHTML = "<img alt='Icon' src='images/icons/deleteicon.svg'>";

                tile.appendChild(gradient);
                tile.appendChild(deleteBtn);

                deleteBtn.onclick = deleteBtn.ontouchstart = function () {
                    deleteBtn.remove();
                    gradient.remove();
                    let index = images.indexOf(image);
                    console.log(index);
                    for (let i = 0; i < AllFiles.length; i++) {
                        if (images[index].filename === AllFiles[i].name) {
                            AllFiles.splice(i, 1);
                        }
                    }
                    images.splice(index, 1);
                    image.remove();
                    PlaceImagesFromArrayInTile();
                };
            }
        };

        tile.onmouseleave = function () {
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
const inputbox = document.querySelector(".inputbox")
const arrow = document.querySelector(".arrowIcon");
let boxIsDicht = true;
let pressedOnCategorieën = false;
bekijkCategorien()
function bekijkCategorien() {

    arrow.parentElement.onclick = function () {
        if (boxIsDicht) {
            boxIsDicht = false
            categorieënBox.classList.add("categoriënboxopen");
            arrow.classList.add("animation")
        } else {
            boxIsDicht = true;
            categorieënBox.classList.remove("categoriënboxopen");
            arrow.classList.remove("animation")
        }
    }
}
categorieënFromDatabase();
function categorieënFromDatabase() {
    xhr = new XMLHttpRequest()
    xhr.onload = function () {
        document.getElementById("categorieënbox").innerHTML = xhr.responseText;
        SelectCategorieën();
    }

    xhr.open('POST', 'database verzoeken/selectCategorieën.php', true);
    xhr.send();

}


function SelectCategorieën() {
    let alleCategorieën = [...document.querySelector(".categoriënbox").children];
    let allecategorieënBox = document.querySelector(".categoriënbox");
    let selectedCategorienBox = document.querySelector(".selectedCategorieën");


    alleCategorieën.forEach(categorie => {
        categorie.onclick = function () {
            if (categorie.parentElement == allecategorieënBox) {
                selectedCategorienBox.appendChild(categorie)
            } else {
                allecategorieënBox.appendChild(categorie)
            }
        }
    });
}

// Plaats advertentie in database
const advertentieform = document.getElementById("advertentiegegevens");
const submitAdvertentieform = document.getElementById("submitBtn");

advertentieform.addEventListener("submit", function (event) {
    event.preventDefault();
    const formData = new FormData(event.target);
    const files = Array.from(AllFiles.slice(0, 10));
    orderArr = {};

    if (files.length < 1) {
        alert("Upload minstens 1 afbeelding");
        return;
    }

    //maakt orderarr
    let iterations = images.length >= 10 ? 10 : images.length;
    for (let i = 0; i < iterations; i++) {
        for (let j = 0; j < AllFiles.length; j++) {
            if (images[i].filename == AllFiles[j].name) {
                orderArr[AllFiles[j].name] = window.getComputedStyle(images[i].parentNode).order;
            }
        }
    }

    let selectedCategorieën = Array.from(document.querySelector(".selectedCategorieën").querySelectorAll("div")).map(element => element.getAttribute('categorieid'));
    loadingScreen();

    files.forEach((file, index) => {
        const reader = new FileReader();
        reader.onload = function (event) {
            const fileContent = event.target.result;

            const img = new Image();
            img.onload = function () {
                const canvas = document.createElement('canvas');
                const ctx = canvas.getContext('2d');

                // Stel de canvasgrootte in op basis van de afbeelding, met een maximale hoogte van 1000px
                const maxWidth = 800;
                const maxHeight = 600;

                let width = img.width;
                let height = img.height;

                if (width > height) {
                    if (width > maxWidth) {
                        height = Math.round((height * maxWidth) / width);
                        width = maxWidth;
                    }
                } else {
                    if (height > maxHeight) {
                        width = Math.round((width * maxHeight) / height);
                        height = maxHeight;
                    }
                }

                canvas.width = width;
                canvas.height = height;

                ctx.drawImage(img, 0, 0, canvas.width, canvas.height);

                const quality = .5;
                const compressedDataUrl = canvas.toDataURL('image/jpeg', quality);
                const blob = dataURLToBlob(compressedDataUrl);
                formData.append(`Image${index}`, blob, file.name);


                if (index === files.length - 1) {
                    formData.append('categorieën', JSON.stringify(selectedCategorieën));
                    formData.append('order', JSON.stringify(orderArr));
                    const xhr = new XMLHttpRequest();
                    xhr.onload = function () {
                        let response = xhr.responseText;
                        stopLoadingAnimation();
                        alert("advertentie succesvol geupload");
                        console.log(response);
                    };

                    // xhr.onloadend = function () {

                    //     console.log("XHR is klaar");
                    // };

                    xhr.open("POST", "database verzoeken/plaatsadvertentie.php", true);
                    xhr.send(formData);
                }
            };
            img.src = URL.createObjectURL(new Blob([fileContent], { type: file.type }));
        };
        reader.readAsArrayBuffer(file);
    });


    //made by chatGTP -|>
    function dataURLToBlob(dataURL) {
        const byteString = atob(dataURL.split(',')[1]);
        const arrayBuffer = new ArrayBuffer(byteString.length);
        const uint8Array = new Uint8Array(arrayBuffer);

        for (let i = 0; i < byteString.length; i++) {
            uint8Array[i] = byteString.charCodeAt(i);
        } 20

        return new Blob([uint8Array], { type: 'image/jpeg' });
    }
});

const loadingImage = document.createElement("img");
const overlay = document.createElement("div");
function loadingScreen() {
    loadingImage.src = "images/loading.png";
    loadingImage.classList.add("rotating");
    loadingImage.classList.add("loadingImage");
    overlay.classList.add("overlay");
    document.body.appendChild(overlay);
    document.body.appendChild(loadingImage);
}

function stopLoadingAnimation() {
    loadingImage.remove();
    overlay.remove();
}

