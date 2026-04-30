# Tâches Restantes - Projet Lumio

D'après le document `PRD.md` et l'état actuel du code, voici les fonctionnalités et intégrations qu'il reste à implémenter :

## 1. Tableau de Bord Administrateur (`admin.php`)
- **Fichier manquant :** Créer le fichier `admin.php` à la racine du projet.
- **Accès Sécurisé :** Restreindre l'accès à cette page uniquement aux utilisateurs ayant le rôle `admin` dans la base de données.
- **Gestion du Stock :** Développer un formulaire complet (CRUD) permettant à l'administrateur d'ajouter de nouveaux produits (image, nom, prix, catégorie, etc.) directement dans la base de données MySQL.

## 2. Dynamisation du Catalogue via la Base de Données
Actuellement, l'affichage des produits repose sur des données statiques simulées en JavaScript (le tableau `PRODUCTS` dans `main.js`).
- **Dans `index.php` :**
  - Supprimer la génération des cartes produits en JavaScript.
  - Utiliser PDO (PHP) pour faire une requête (`SELECT * FROM produits`) et afficher les produits à l'aide d'une boucle `foreach`.
  - Adapter le système de recherche et de filtres par catégorie pour qu'il fonctionne avec la base de données.
- **Dans `produit.php` :**
  - Récupérer l'identifiant du produit via l'URL (`$_GET['id']`).
  - Interroger la base de données pour obtenir les informations de ce produit spécifique et les afficher.

## 3. Gestion du Panier côté Serveur (Sessions/BDD)
Actuellement, le panier est géré uniquement côté client via JavaScript et le `localStorage`.
- **Backend PHP :** Le PRD exige que l'état du panier soit géré côté serveur, préférentiellement via les sessions PHP (`$_SESSION['panier']`).
- **Actions :** Convertir la logique d'ajout, de modification des quantités et de suppression du panier (actuellement en JS) pour qu'elle passe par des scripts PHP.

## 4. Nettoyage de la Logique d'Authentification
- **Redondance :** L'authentification a commencé à être implémentée correctement en PHP dans `login.php` (utilisation de requêtes préparées avec PDO). Cependant, le fichier `main.js` contient toujours des fonctions de simulation (`initAuthPage`, stockage dans `localStorage`).
- **Action :** Supprimer cette logique JavaScript simulée pour que l'inscription et la connexion s'appuient à 100 % sur PHP et la base de données.

## 5. Finalisation de la Structure du Projet
- **Connexion BDD :** Selon la section 6 du PRD, la connexion doit se trouver dans `config/db.php`. Actuellement, les fichiers `config/database.php` et `config/app.php` sont utilisés. Il faut uniformiser selon les exigences.
- **Inclusions (`includes/`) :** Extraire les éléments HTML répétitifs (comme le `<header>` et le `<footer>` présents dans chaque fichier) et les placer dans des fichiers séparés (`includes/header.php`, `includes/footer.php`) pour un code plus propre et maintenable.
