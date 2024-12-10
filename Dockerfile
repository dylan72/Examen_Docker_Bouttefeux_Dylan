# Image de base de docker pour PHP 8.2 avec Apache
FROM php:8.2-apache

# Installer les dépendances nécessaires
RUN docker-php-ext-install pdo pdo_mysql

# Copier les fichiers dans le conteneur
COPY app/ /var/www/html/

# Donner les permissions nécessaires
RUN chmod -R 777 /var/www/html/results.json

# Exposer le port 80
EXPOSE 80

