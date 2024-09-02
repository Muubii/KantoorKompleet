document.addEventListener("DOMContentLoaded", function () {



    const imgBox = document.querySelector(".imgBox");
    const IconInDb = document.querySelector("#bedrijfslogo");
    console.log(IconInDb)

    if (imgBox) {

        let LogoInput = document.querySelector("#LogoInput");
        LogoInput.addEventListener("change", function (event) {
            const file = event.target.files[0];
            console.log(file);
            if (file) {
                var maxSize = 2 * 1024 * 1024; // 2 MB in bytes
                if (file && file.size > maxSize) {
                    alert("Bestand is te groot. Maximale grootte toegestaan is 2 MB.");
                    LogoInput.value = "";
                    return;
                }
                const reader = new FileReader();
                reader.onload = function (e) {
                    const base64 = e.target.result;
                    const img = document.createElement("img");
                    img.src = base64;
                    img.id = "bedrijfslogo";
                    const box = document.querySelector(".bedrijfslogoBox")
                    imgBox.classList.add("hidden");
                    box.appendChild(img);
                }
                reader.readAsDataURL(file);
            }
        })
    }

    const profielForm = document.querySelector("#profielForm");
    let submit;
    profielForm.addEventListener("submit", function (event) {
        submit = true;
        event.preventDefault();
        console.log(event.target)
        const form = document.getElementById('profielForm');
        const formData = new FormData(form);
        let xhr = new XMLHttpRequest();
        xhr.onload = function () {
            console.log(xhr.responseText)
            alert("Profiel succesvol geüpdatet")
        }
        xhr.open("POST", "database verzoeken/profielGegevens.php");
        xhr.send(formData);
    })


    const bedrijfsLogoBox = document.querySelector('.bedrijfslogoBox');

    bedrijfsLogoBox.onmouseover = deleteBedrijfsIcon;
    bedrijfsLogoBox.onmouseleave = removeBtn;
    bedrijfsLogoBox.onclick = deleteBedrijfsIcon;

    function removeBtn() {
        const logo = bedrijfsLogoBox.querySelector("button")
        if (logo) {
            logo.remove()
        };
    }
    function deleteBedrijfsIcon() {
        if (bedrijfsLogoBox.querySelector("#bedrijfslogo") && !bedrijfsLogoBox.querySelector("button")) {
            const deleteBtn = document.createElement("button");
            deleteBtn.classList.add("deleteBedrijfsIcon");
            deleteBtn.innerHTML = "DELETE";
            deleteBtn.type = "button";
            deleteBtn.id = "deleteImageBtn";
            bedrijfsLogoBox.appendChild(deleteBtn);

            deleteBtn.onclick = function () {
                if (IconInDb || submit) {
                    let xhr = new XMLHttpRequest();
                    xhr.onload = function () {
                        console.log(xhr.responseText);
                    }
                    xhr.open('POST', 'database verzoeken/deleteBedrijfsIcon.php');
                    xhr.send();
                }
                removeBtn()
                document.querySelector("#bedrijfslogo").remove()
                imgBox.classList.remove("hidden");
                document.querySelector("#LogoInput").value = "";
            }
        }
    }
})



