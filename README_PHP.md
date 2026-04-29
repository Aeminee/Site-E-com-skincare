## Migration PHP (rapide)

1. Installe XAMPP/WAMP/Laragon et place le projet dans `htdocs`.
2. Crée la base avec `database.sql` (phpMyAdmin > Import).
3. Vérifie `config/app.php` (host, user, password MySQL).
4. Ouvre le site via:
   - `http://localhost/Pweb/index.php`
   - `http://localhost/Pweb/login.php`

### Fichiers ajoutés

- `config/app.php`: constantes + helpers.
- `config/database.php`: connexion PDO.
- `bootstrap.php`: session + bootstrap.
- `auth.php`: helpers utilisateur session.
- `login.php`: connexion + inscription serveur.
- `index.php`, `produit.php`, `panier.php`: versions PHP des pages.
- `logout.php`: déconnexion.
- `database.sql`: schéma initial (`users`).

### Important

- Les pages `.html` sont conservées.
- Utilise désormais en priorité les pages `.php`.
