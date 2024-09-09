const inlogForm = document.querySelector("#inlogForm");
if(inlogForm){
    inlogForm.addEventListener("submit", function(event){
        event.preventDefault();
        const formData = new FormData(inlogForm);

        const xhr = new XMLHttpRequest();
        xhr.onload = function(){
            if(xhr.responseText.includes("Ongeldige")){
                alert("Ongeldige gebruikersnaam of wachtwoord.");
            }else{
                window.location = "/";
            }
        }
        xhr.open("POST", "database verzoeken/login.php");
        xhr.send(formData);
    });
}



const registreerForm = document.querySelector("#registreer");
if(registreerForm){
    registreerForm.addEventListener("submit", function(event){
        event.preventDefault();
        const formData = new FormData(registreerForm);

        const xhr = new XMLHttpRequest();
        xhr.onload = function(){
            console.log(xhr.responseText)
            if(xhr.responseText.includes("Bedrijfsnaam")){
                alert("Bedrijfsnaam is al in bezet");
            }else{
                window.location = "/";
            }
        }
        xhr.open("POST", "database verzoeken/registreren.php");
        xhr.send(formData);
    });
}
