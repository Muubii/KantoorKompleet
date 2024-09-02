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