// Afficher le bouton quand l'utilisateur fait défiler vers le bas
window.onscroll = function() {scrollFunction()};

function scrollFunction() {
    var button = document.getElementById("backToTopButton");
    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
        button.style.display = "block";
    } else {
        button.style.display = "none";
    }
}

// Scroll vers le haut de la page quand l'utilisateur clique sur le bouton
document.getElementById('backToTopButton').addEventListener('click', function() {
    document.body.scrollTop = 0;
    document.documentElement.scrollTop = 0;
});

