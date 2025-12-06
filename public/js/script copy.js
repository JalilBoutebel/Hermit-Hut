/* fichier js */
document.addEventListener("DOMContentLoaded", function () {
  const modal = document.getElementById("gameModal");
  const modalBody = document.getElementById("modalBody");
  const closeBtn = document.querySelector(".close-modal");

  // Fonction pour ouvrir le modal
  function openModal(jeuData) {
    const content = `
            <div class="details-content">
                <h2>${jeuData.libelle}</h2>
                <img src="${jeuData.image}" alt="${jeuData.libelle}" class="details-img">
                <p><strong>Catégorie :</strong> ${jeuData.categorie}</p>
                <p>${jeuData.description}</p>
                <p class="price">💰 ${jeuData.prix} €</p>
                <a href="/panier/add/${jeuData.id}" class="btn-add">🛒 Ajouter au panier</a>
            </div>
        `;
    modalBody.innerHTML = content;
    modal.style.display = "block";
    document.body.style.overflow = "hidden"; // Empêche le scroll
  }

  // Fonction pour fermer le modal
  function closeModal() {
    modal.style.display = "none";
    document.body.style.overflow = "auto";
  }

  // Ouvrir via le bouton Details
  document.querySelectorAll(".open-details").forEach((button) => {
    button.addEventListener("click", function (e) {
      e.preventDefault();
      const img = this.previousElementSibling.previousElementSibling;
      const jeuData = {
        id: img.dataset.jeuId,
        libelle: img.dataset.jeuLibelle,
        image: img.dataset.jeuImage,
        categorie: img.dataset.jeuCategorie,
        description: img.dataset.jeuDescription,
        prix: img.dataset.jeuPrix,
      };
      openModal(jeuData);
    });
  });

  // Ouvrir via clic sur l'image
  document.querySelectorAll(".game-image").forEach((img) => {
    img.addEventListener("click", function () {
      const jeuData = {
        id: this.dataset.jeuId,
        libelle: this.dataset.jeuLibelle,
        image: this.dataset.jeuImage,
        categorie: this.dataset.jeuCategorie,
        description: this.dataset.jeuDescription,
        prix: this.dataset.jeuPrix,
      };
      openModal(jeuData);
    });
  });

  // Fermer via le X
  closeBtn.addEventListener("click", closeModal);

  // Fermer via clic en dehors du modal
  window.addEventListener("click", function (e) {
    if (e.target === modal) {
      closeModal();
    }
  });

  // Fermer via touche Escape
  document.addEventListener("keydown", function (e) {
    if (e.key === "Escape" && modal.style.display === "block") {
      closeModal();
    }
  });
});
