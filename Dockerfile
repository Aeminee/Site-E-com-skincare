FROM php:8.2-apache

# Installer les extensions PHP nécessaires (PDO MySQL)
RUN docker-php-ext-install pdo pdo_mysql

# Activer le mod_rewrite d'Apache (utile pour les URL propres)
RUN a2enmod rewrite

# Définir le dossier de travail
WORKDIR /var/www/html

# Copier les fichiers du projet (optionnel si on utilise les volumes dans docker-compose)
COPY . /var/www/html/
