document.addEventListener("DOMContentLoaded", () => {

    //als je op de profilebox klikt komt er een menu uit.
    const profilebox = document.querySelector(".user_acc");
    profilebox.onclick = function () {
        profilebox.classList.add("open");
    }
    let canProfileBoxClose;
    profilebox.onmouseenter = function () {
        canProfileBoxClose = false;
    }
    profilebox.onmouseleave = function () {
        canProfileBoxClose = true;
    }
    document.onclick = function () {
        if (profilebox.classList.contains("open") && canProfileBoxClose) {
            profilebox.classList.remove("open");
        }
    }
    const profielOption = document.querySelector(".profiel");
    profielOption.onclick = function () {
        if (location.pathname != '/profiel.php') {
            location.href = "/profiel.php";
        }
    }
    const uitlogOption = document.querySelector(".uitloggen");
    uitlogOption.onclick = function () {

        xhr = new XMLHttpRequest()
        xhr.onload = function () {
            console.log(xhr.responseText)
            location.href = "/login.html";
        }
        xhr.open("POST", "php/deleteSessions.php");
        xhr.send();
    }
    const chatBtn = document.querySelector("#chatbtn");
    chatBtn.onclick = function () {
        window.location.href = "/chat.php";
    }
    const plaatsaddbtn = document.querySelector("#plaatsaddbtn");
    plaatsaddbtn.onclick = function () {
        window.location.href = "/plaatsadvertentie.php";
    }
    const mijnadvertentiesbtn = document.querySelector("#mijnaddbtn");
    mijnadvertentiesbtn.onclick = function () {
        window.location.href = "/mijnadvertenties.php";
    }


    const sideBar = document.createElement("div");
    const closeSidebarBtn = document.createElement("button");
    const closeIcon = document.createElement("img");

    function voegSidebarToe() {

        sideBar.id = "sidebar";
        sideBar.className = "sidebar";
        closeSidebarBtn.className = "closeSidebarBtn";
        closeIcon.src = "images/icons/zoekicon.svg";
        closeIcon.alt = "icon";
        closeIcon.className = "icon";

        closeSidebarBtn.appendChild(closeIcon);
        sideBar.appendChild(closeSidebarBtn);
        document.body.appendChild(sideBar);
    }
    voegSidebarToe();

    const hamburgermenuBtn = document.querySelector("#hamburgerMenu");
    const navBtns = Array.from(document.querySelectorAll(".navBtn"));
    const headerNav = document.querySelector(".headerNav");


    hamburgermenuBtn.onclick = function () {
        sideBar.classList.add("sidebarOpen");

        navBtns.forEach(filter => {
            sideBar.appendChild(filter);
        });

        closeSidebarBtn.onclick = function () {
            sideBar.classList.remove("sidebarOpen");
            navBtns.reverse().forEach(filter => {
                headerNav.insertBefore(filter, headerNav.children[1]);
            });
        }
    };


    function updateFiltersPosition() {
        if (window.innerWidth > 800 && sideBar.classList.contains("sidebarOpen")) {
            sideBar.classList.remove("sidebarOpen");
            navBtns.reverse().forEach(filter => {
                headerNav.insertBefore(filter, headerNav.children[1]);
            });
        }
    }
    window.addEventListener('resize', updateFiltersPosition);
})