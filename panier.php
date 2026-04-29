<?php

declare(strict_types=1);

require_once __DIR__ . '/includes/auth.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>LUMIO — Mon Panier</title>
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
        <a href="panier.php" class="btn-icon cart-btn active" id="cart-toggle" aria-label="Panier">
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

      <div class="page-header">
        <h1 class="page-title">Mon panier</h1>
        <span class="page-subtitle" id="cart-item-count">0 article</span>
      </div>

      <!-- PHP: Récupérer les données du panier depuis la session ou la BDD -->
      <!-- Si connecté : SELECT * FROM panier WHERE user_id = $_SESSION['user_id'] -->
      <!-- Si non connecté : utiliser $_SESSION['panier'] -->

      <div class="cart-layout" id="cart-layout">

        <!-- Tableau panier -->
        <section class="cart-items-section" aria-label="Articles du panier">

          <!-- Panier vide -->
          <div class="cart-empty" id="cart-empty" hidden>
            <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z"/></svg>
            <h2>Votre panier est vide</h2>
            <p>Découvrez nos produits et commencez votre sélection.</p>
            <a href="index.php" class="btn btn-primary">Retour à la boutique</a>
          </div>

          <!-- Liste des articles -->
          <div id="cart-items-list">
            <!-- Généré par main.js -->
          </div>

        </section>

        <!-- Récapitulatif commande -->
        <aside class="cart-summary" id="cart-summary" aria-label="Récapitulatif de la commande">
          <h2 class="summary-title">Récapitulatif</h2>

          <div class="summary-line">
            <span>Sous-total</span>
            <span id="summary-subtotal">0,00 €</span>
          </div>
          <div class="summary-line">
            <span>Livraison</span>
            <span id="summary-shipping">Gratuite</span>
          </div>

          <!-- Code promo -->
          <div class="promo-group">
            <input type="text" id="promo-input" class="promo-input" placeholder="Code promo" aria-label="Code promo" />
            <button class="btn btn-outline btn-sm" id="promo-btn">Appliquer</button>
          </div>
          <div class="summary-line promo-line" id="promo-line" hidden>
            <span>Réduction</span>
            <span id="summary-discount" class="text-accent">— 0,00 €</span>
          </div>

          <div class="summary-line summary-total">
            <span>Total TTC</span>
            <span id="summary-total">0,00 €</span>
          </div>

          <!-- PHP: Rediriger vers checkout.php après validation -->
          <button class="btn btn-primary btn-full btn-checkout" id="btn-checkout">
            Passer la commande
          </button>

          <!-- PHP: Vérifier si l'utilisateur est connecté avant de permettre la commande -->
          <!-- Si non connecté : rediriger vers login.php?redirect=checkout -->
          <p class="secure-mention">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z"/></svg>
            Paiement 100 % sécurisé
          </p>

          <div class="payment-logos" aria-label="Moyens de paiement acceptés">
            <span class="payment-logo">VISA</span>
            <span class="payment-logo">MC</span>
            <span class="payment-logo">PayPal</span>
          </div>
        </aside>

      </div>
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
