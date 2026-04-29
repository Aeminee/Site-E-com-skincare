<?php

declare(strict_types=1);

require_once __DIR__ . '/includes/auth.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>LUMIO — Détail produit</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="assets/css/style.css" />
</head>
<body>

  <header class="site-header">
    <div class="container header-inner">
      <a href="index.php" class="logo">LUMIO</a>
      <nav class="nav-main" aria-label="Navigation principale">
        <a href="index.php" class="nav-link">Boutique</a>
        <a href="#" class="nav-link">Nouveautés</a>
        <a href="#" class="nav-link">Marques</a>
        <a href="#" class="nav-link">Promotions</a>
      </nav>
      <div class="header-actions">
        <a href="login.php" class="btn-icon" aria-label="Mon compte">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/></svg>
        </a>
        <a href="panier.php" class="btn-icon cart-btn" id="cart-toggle" aria-label="Panier">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z"/></svg>
          <span class="cart-count" id="cart-count">0</span>
        </a>
        <button class="burger" id="burger-btn" aria-label="Menu mobile"><span></span><span></span><span></span></button>
      </div>
    </div>
    <nav class="nav-mobile" id="nav-mobile">
      <a href="index.php" class="nav-link">Boutique</a>
      <a href="login.php" class="nav-link">Mon compte</a>
      <a href="panier.php" class="nav-link">Panier</a>
    </nav>
  </header>

  <main>
    <div class="container">

      <!-- Fil d'Ariane -->
      <nav class="breadcrumb" aria-label="Fil d'Ariane">
        <a href="index.php">Boutique</a>
        <span aria-hidden="true">›</span>
        <!-- PHP: Afficher dynamiquement la catégorie et le nom du produit -->
        <span id="breadcrumb-category">Maison</span>
        <span aria-hidden="true">›</span>
        <span id="breadcrumb-name">Chargement…</span>
      </nav>

      <!-- Détail produit -->
      <!-- PHP: Remplir cette section avec les données du produit depuis la BDD (SELECT * FROM produits WHERE id = $_GET['id']) -->
      <section class="product-detail" id="product-detail" aria-label="Détail du produit">

        <div class="product-gallery">
          <img id="product-img-main" src="" alt="Image produit" class="product-img-main" />
          <div class="product-thumbnails" id="product-thumbnails">
            <!-- Miniatures générées dynamiquement -->
          </div>
        </div>

        <div class="product-info">
          <span class="product-category-badge" id="product-category">—</span>
          <h1 class="product-title-detail" id="product-name">Chargement…</h1>

          <div class="product-rating">
            <span class="stars" id="product-stars">★★★★☆</span>
            <span class="rating-count" id="product-rating-count">(0 avis)</span>
          </div>

          <p class="product-price-detail" id="product-price">—</p>
          <p class="product-price-old" id="product-price-old"></p>

          <p class="product-description" id="product-description">Chargement de la description…</p>

          <!-- Options -->
          <div class="product-options">
            <div class="option-group" id="color-group">
              <label class="option-label">Couleur</label>
              <div class="color-swatches" id="color-swatches"></div>
            </div>
            <div class="option-group">
              <label class="option-label" for="qty-input">Quantité</label>
              <div class="qty-control">
                <button class="qty-btn" id="qty-minus" aria-label="Diminuer">−</button>
                <input type="number" id="qty-input" class="qty-input" value="1" min="1" max="99" aria-label="Quantité" />
                <button class="qty-btn" id="qty-plus" aria-label="Augmenter">+</button>
              </div>
            </div>
          </div>

          <div class="product-actions">
            <button class="btn btn-primary btn-add btn-full" id="btn-add-cart">Ajouter au panier</button>
            <button class="btn btn-outline" id="btn-wishlist" aria-label="Ajouter aux favoris">
              <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z"/></svg>
            </button>
          </div>

          <!-- Infos livraison -->
          <div class="product-meta-info">
            <div class="meta-item">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 0 1-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 0 0-3.213-9.193 2.056 2.056 0 0 0-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 0 0-10.026 0 1.106 1.106 0 0 0-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12"/></svg>
              <span>Livraison gratuite dès 50 €</span>
            </div>
            <div class="meta-item">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
              <span>Retour gratuit sous 30 jours</span>
            </div>
          </div>
        </div>
      </section>

      <!-- Produits similaires -->
      <section class="related-products">
        <h2 class="section-title">Vous pourriez aussi aimer</h2>
        <!-- PHP: Requête pour les produits de même catégorie -->
        <div class="product-grid" id="related-grid"></div>
      </section>

    </div>
  </main>

  <aside class="cart-drawer" id="cart-drawer" aria-label="Panier rapide" aria-hidden="true">
    <div class="cart-drawer-header">
      <h2>Mon panier</h2>
      <button class="drawer-close" id="drawer-close" aria-label="Fermer le panier">×</button>
    </div>
    <div class="cart-drawer-items" id="cart-drawer-items"></div>
    <div class="cart-drawer-footer">
      <div class="cart-drawer-total">
        <span>Total</span>
        <strong id="cart-drawer-total">0,00 €</strong>
      </div>
      <a href="panier.php" class="btn btn-primary btn-full">Voir le panier</a>
    </div>
  </aside>
  <div class="drawer-overlay" id="drawer-overlay" hidden></div>

  <footer class="site-footer">
    <div class="container footer-inner">
      <div class="footer-brand"><span class="logo">LUMIO</span><p>L'essentiel, réimagagné.</p></div>
      <div class="footer-links"><h3>Boutique</h3><a href="#">Nouveautés</a><a href="#">Promotions</a></div>
      <div class="footer-links"><h3>Support</h3><a href="#">FAQ</a><a href="#">Contact</a></div>
      <div class="footer-links"><h3>Légal</h3><a href="#">CGV</a><a href="#">Confidentialité</a></div>
    </div>
    <div class="footer-bottom"><p>&copy; 2025 LUMIO. Projet académique.</p></div>
  </footer>

  <div class="toast" id="toast" role="alert" aria-live="polite"></div>
  <script src="assets/js/main.js"></script>
</body>
</html>
