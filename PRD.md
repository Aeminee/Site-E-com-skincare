# Product Requirement Document (PRD) - Projet Lumio

## 1. Vision du Projet
**Nom du Projet :** Lumio - Boutique E-Commerce
**Contexte :** Projet académique de 3ème année (Génie Logiciel) pour le module Programmation Web.
**Niche :** Cosmétique haut de gamme, approche minimaliste, clinique et unisexe.
**Objectif :** Développer une application Full-Stack complète démontrant la gestion du cycle de vie des données (CRUD), la sécurité des sessions et l'interactivité frontend.

---

## 2. Stack Technique
- **Frontend :** HTML5 (sémantique), CSS3 (Grid/Flexbox), JavaScript (Vanilla).
- **Backend :** PHP (orienté script ou MVC simplifié).
- **Base de Données :** MySQL (Utilisation de PDO impérative pour la sécurité).
- **Gestion d'état :** Sessions PHP (auth) et Cookies (préférences/persistance).

---

## 3. Architecture des Données (Base de Données)
Le projet doit comporter au minimum les tables suivantes :
- **Produits :** `id`, `nom`, `description`, `prix`, `image_url`, `categorie_id`.
- **Utilisateurs :** `id`, `nom`, `email`, `password` (hashé), `role` (client/admin).
- **Panier/Commandes :** Lien entre utilisateurs et produits.

---

## 4. Fonctionnalités à Implémenter (Exigences du Professeur)

### 4.1 Catalogue et Recherche
- **Page Boutique :** Affichage dynamique des items provenant de la base de données.
- **Détails Produit :** Chaque item doit avoir une page dédiée avec sa description et son prix.
- **Filtrage :** Système de recherche par nom et filtrage par catégorie (Soins, Nettoyants, etc.).

### 4.2 Gestion Utilisateur & Panier
- **Authentification :** Système complet de Connexion / Déconnexion.
- **Sessions & Cookies :** Utilisation des sessions pour maintenir l'utilisateur connecté et des cookies pour stocker des informations de navigation.
- **Le Panier :** 
    - Ajouter/Enlever des items.
    - Consulter l'état du panier en temps réel (total, liste des articles).

### 4.3 Administration
- **Accès Sécurisé :** Seul un utilisateur avec le rôle 'admin' peut accéder à cette section.
- **Gestion du Stock :** Interface pour ajouter de nouveaux produits directement dans la base de données.

---

## 5. Directives UI/UX (Style Lumio)
- **Esthétique :** Minimaliste, propre, professionnel, évitant les clichés féminins.
- **Palette de Couleurs :** Neutres (Gris, Blanc, Noir) avec des accents typés "laboratoire" ou "technique".
- **Interactions :** Micro-animations au survol des cartes produits, transitions fluides.
- **Multimédia :** Utilisation de vidéos de background (textures macro, mouvements lents) pour le hero banner.

---

## 6. Structure du Projet
```text
/
├── config/             # Connexion DB (db.php)
├── assets/             # CSS, JS, Images, Vidéos
├── includes/           # Header, Footer, Fonctions réutilisables
├── index.php           # Page d'accueil (Catalogue)
├── produit.php         # Détail d'un item
├── panier.php          # Gestion du panier
├── login.php           # Connexion/Inscription
├── admin.php           # Dashboard admin (Ajout items)
└── PRD.md              # Ce document