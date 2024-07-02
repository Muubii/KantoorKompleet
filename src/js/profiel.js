document.addEventListener("DOMContentLoaded", function(){
    const profielForm = document.querySelector("#profielForm");

    profielForm.addEventListener("submit", function(event){
        event.preventDefault();
        console.log(event.target)
        const form = document.getElementById('profielForm');
        const formData = new FormData(form);
        let xhr = new XMLHttpRequest();
        xhr.onload = function(){
            console.log(xhr.responseText)
        }
        xhr.open("POST", "database verzoeken/profielGegevens.php");
        xhr.send(formData);
    })


    const bedrijfsLogoBox = document.querySelector('.bedrijfslogoBox');

    bedrijfsLogoBox.onmouseenter = deleteBedrijfsIcon;
    bedrijfsLogoBox.onmouseleave = removeBtn;
    bedrijfsLogoBox.onclick = deleteBedrijfsIcon;

function removeBtn(){
    const logo = bedrijfsLogoBox.querySelector("button")
    if(logo){
        logo.remove()
    };
}
    function deleteBedrijfsIcon(){
        if(bedrijfsLogoBox.querySelector("img") && !bedrijfsLogoBox.querySelector("button")){
            console.log("Yeeeaaaa");
            const deleteBtn = document.createElement("button");
            deleteBtn.classList.add("deleteBedrijfsIcon");
            deleteBtn.innerHTML = "DELETE";
            deleteBtn.type = "button";
            bedrijfsLogoBox.appendChild(deleteBtn);

            deleteBtn.onclick = function(){
                let xhr = new XMLHttpRequest();
                xhr.onload = function(){
                    console.log(xhr.responseText);
                    bedrijfsLogoBox.innerHTML = '<input type="file" id="LogoInput" name="Logo" accept=".jpg,.png,.jpeg"">';
                }
                xhr.open('POST', 'database verzoeken/deleteBedrijfsIcon.php');
                xhr.send();
            }
        } else{
            return;
        }
    }
})



