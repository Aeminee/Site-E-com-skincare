<?php

declare(strict_types=1);

require_once __DIR__ . '/includes/auth.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>LUMIO — Boutique</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="assets/css/style.css" />
</head>
<body>

  <!-- ========== HEADER ========== -->
  <header class="site-header">
    <div class="container header-inner">
      <a href="index.php" class="logo">LUMIO</a>

      <nav class="nav-main" aria-label="Navigation principale">
        <a href="index.php" class="nav-link active">Boutique</a>
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
        <button class="burger" id="burger-btn" aria-label="Menu mobile">
          <span></span><span></span><span></span>
        </button>
      </div>
    </div>
    <!-- Mobile nav -->
    <nav class="nav-mobile" id="nav-mobile">
      <a href="index.php" class="nav-link">Boutique</a>
      <a href="#" class="nav-link">Nouveautés</a>
      <a href="#" class="nav-link">Marques</a>
      <a href="#" class="nav-link">Promotions</a>
      <a href="login.php" class="nav-link">Mon compte</a>
      <a href="panier.php" class="nav-link">Panier</a>
    </nav>
  </header>

  <!-- ========== HERO ========== -->
  <section class="hero">
    <div class="container hero-inner">
      <p class="hero-tag">Nouvelle collection</p>
      <h1 class="hero-title">L'essentiel, <em>reimagine</em></h1>
      <p class="hero-sub">Des produits soigneusement sélectionnés pour simplifier votre quotidien.</p>
      <a href="#products" class="btn btn-primary">Découvrir la boutique</a>
    </div>
  </section>

  <!-- ========== MAIN ========== -->
  <main id="products">
    <div class="container">

      <!-- Barre de recherche + filtres -->
      <div class="shop-controls">
        <div class="search-wrapper">
          <svg class="search-icon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/></svg>
          <input
            type="search"
            id="search-input"
            class="search-input"
            placeholder="Rechercher un produit…"
            aria-label="Rechercher un produit"
          />
        </div>
        <div class="filter-tabs" id="filter-tabs">
          <button class="filter-btn active" data-category="all">Tous</button>
          <button class="filter-btn" data-category="soin-visage">Soin visage</button>
          <button class="filter-btn" data-category="maquillage">Maquillage</button>
          <button class="filter-btn" data-category="nettoyant">Nettoyant</button>
          <button class="filter-btn" data-category="capillaire">Capillaire</button>
          <button class="filter-btn" data-category="parfum">Parfum</button>
          <button class="filter-btn filter-reset" id="filter-reset" type="button">Reinitialiser</button>
        </div>
      </div>

      <!-- Grille de produits -->
      <!-- PHP: Remplacer cette section par une boucle PHP qui génère les cartes dynamiquement depuis la BDD -->
      <p class="results-count" id="results-count"></p>
      <section class="product-grid" id="product-grid" aria-label="Liste des produits">
        <!-- Les cartes produit sont générées par main.js -->
      </section>

      <p class="no-results" id="no-results" hidden>Aucun produit trouvé pour cette recherche.</p>
    </div>
  </main>

  <!-- ========== FOOTER ========== -->
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
      <div class="footer-brand">
        <span class="logo">LUMIO</span>
        <p>L'essentiel, réimagagné.</p>
      </div>
      <div class="footer-links">
        <h3>Boutique</h3>
        <a href="#">Nouveautés</a>
        <a href="#">Promotions</a>
        <a href="#">Marques</a>
      </div>
      <div class="footer-links">
        <h3>Support</h3>
        <a href="#">FAQ</a>
        <a href="#">Livraison & retours</a>
        <a href="#">Contact</a>
      </div>
      <div class="footer-links">
        <h3>Légal</h3>
        <a href="#">CGV</a>
        <a href="#">Confidentialité</a>
        <a href="#">Mentions légales</a>
      </div>
    </div>
    <div class="footer-bottom">
      <p>&copy; 2025 LUMIO. Projet académique.</p>
    </div>
  </footer>

  <div class="toast" id="toast" role="alert" aria-live="polite"></div>
  <script src="assets/js/main.js"></script>
</body>
</html>
