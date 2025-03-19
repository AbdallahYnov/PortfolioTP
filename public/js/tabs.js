function openTab(event, tabName) {
    var i, tabContent, tabLinks;

    // Masquer tous les contenus
    tabContent = document.getElementsByClassName("tab-content");
    for (i = 0; i < tabContent.length; i++) {
        tabContent[i].style.display = "none";
    }

    // Retirer la classe active des boutons
    tabLinks = document.getElementsByClassName("tab-link");
    for (i = 0; i < tabLinks.length; i++) {
        tabLinks[i].classList.remove("active");
    }

    // Afficher l'onglet sélectionné
    document.getElementById(tabName).style.display = "block";
    event.currentTarget.classList.add("active");
}

// Afficher par défaut l'onglet Connexion
document.addEventListener("DOMContentLoaded", function() {
    document.getElementById("login").style.display = "block";
});

// Fonction pour afficher le formulaire de connexion
function showLogin() {
    document.getElementById('loginForm').style.display = 'block';
    document.getElementById('registerForm').style.display = 'none';
}

// Fonction pour afficher le formulaire d'inscription
function showRegister() {
    document.getElementById('loginForm').style.display = 'none';
    document.getElementById('registerForm').style.display = 'block';
}
