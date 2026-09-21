/* =====================================================
   SIRIUS DIGITAL - JAVASCRIPT
   ===================================================== */


/* ================= ANIMATION AU DÉFILEMENT ================= */

const elements = document.querySelectorAll(
    ".domain-card, .service-card, .project-card, .news-card, .about-content"
);

const observer = new IntersectionObserver(
    (entries) => {

        entries.forEach((entry) => {

            if (entry.isIntersecting) {

                entry.target.classList.add("show");

            }

        });

    },
    {
        threshold: 0.15
    }
);


elements.forEach((element) => {

    element.classList.add("hidden");

    observer.observe(element);

});


/* ================= FORMULAIRE DE CONTACT ================= */



/* ================= ANNÉE AUTOMATIQUE ================= */

const annee = new Date().getFullYear();

const footerText = document.querySelector(".footer-bottom p");

if (footerText) {

    footerText.textContent =
        "© " + annee +
        " Sirius Digital - Tous droits réservés.";

}


/* ================= BOUTON RETOUR EN HAUT ================= */

const boutonTop = document.createElement("button");

boutonTop.innerHTML = "↑";

boutonTop.classList.add("back-to-top");

document.body.appendChild(boutonTop);


window.addEventListener("scroll", function () {

    if (window.scrollY > 400) {

        boutonTop.classList.add("active");

    } else {

        boutonTop.classList.remove("active");

    }

});


boutonTop.addEventListener("click", function () {

    window.scrollTo({
        top: 0,
        behavior: "smooth"
    });

});


/* ================= MENU MOBILE ================= */

const menuToggle = document.getElementById("menu-toggle");
const mainNavbar = document.getElementById("main-navbar");

if (menuToggle && mainNavbar) {

    menuToggle.addEventListener("click", function () {

        const isOpen = mainNavbar.classList.toggle("active");
        menuToggle.setAttribute("aria-expanded", String(isOpen));

        if (isOpen) {
            menuToggle.innerHTML = '<i class="fa-solid fa-xmark"></i>';
        } else {
            menuToggle.innerHTML = '<i class="fa-solid fa-bars"></i>';
        }

    });

    mainNavbar.querySelectorAll("a").forEach((link) => {
        link.addEventListener("click", function () {
            mainNavbar.classList.remove("active");
            menuToggle.setAttribute("aria-expanded", "false");
            menuToggle.innerHTML = '<i class="fa-solid fa-bars"></i>';
        });
    });

}


/* ================= MESSAGE CONSOLE ================= */

console.log(
    "Sirius Digital : site chargé avec succès."
);