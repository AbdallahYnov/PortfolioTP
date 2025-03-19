document.addEventListener('DOMContentLoaded', function () {
    let currentIndex = 0; // Indice de la carte affichée
    const items = document.querySelectorAll('.carousel-item');
    const totalItems = items.length;
    
    function showCard(index) {
        const carouselContent = document.querySelector('.carousel-content');
        const cardWidth = items[0].offsetWidth + 20; // Largeur des cartes + margin
    
        // Déplacer le carrousel
        carouselContent.style.transform = `translateX(-${index * cardWidth}px)`;
    }
    
    function nextCard() {
        if (currentIndex < totalItems - 1) {
            currentIndex++;
            showCard(currentIndex);
        } else {
            currentIndex = 0; // Revenir au début
            showCard(currentIndex);
        }
    }
    
    function prevCard() {
        if (currentIndex > 0) {
            currentIndex--;
            showCard(currentIndex);
        } else {
            currentIndex = totalItems - 1; // Aller à la fin
            showCard(currentIndex);
        }
    }
    
    // Attacher les boutons
    document.querySelector('.next-btn').addEventListener('click', nextCard);
    document.querySelector('.prev-btn').addEventListener('click', prevCard);
    
    // Afficher la première carte lors du chargement
    document.addEventListener("DOMContentLoaded", () => {
        showCard(currentIndex);
    });
})    
