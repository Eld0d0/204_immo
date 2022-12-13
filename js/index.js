window.addEventListener("DOMContentLoaded", function () {
    /* Bouton reset qui fonctionne comme un lien */
    let bouton_form_reset = document.getElementById("form_reset");

    bouton_form_reset.addEventListener("click", function () {
        window.open("index.php", "_self");
    });
    /* Fin bouton reset */

    /* Animation d'apparition lors du chargement */
    let logements = document.getElementsByClassName("logement");

    for (var i =0; i < logements.length; i++) {
        logements[i].style.transform = "translateX(0)";
        logements[i].style.opacity = "1";
        logements[i].style.transitionDuration = 2.5 + i/2 + "s";
    };

    /* Fin d'animation */
});