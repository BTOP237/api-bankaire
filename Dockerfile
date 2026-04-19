# Utiliser une image PHP avec Apache
FROM php:7.4-apache

# Installer les extensions requises
RUN docker-php-ext-install sqlite3 pdo_sqlite

# Activer mod_rewrite pour Apache
RUN a2enmod rewrite

# Copier les fichiers du projet
COPY . /var/www/html

# Définir les permissions
RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html

# Copier la configuration Apache pour le port 8080
COPY public/apache-config.conf /etc/apache2/sites-available/000-default.conf

# Installer Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Installer les dépendances PHP (sans dev pour la production)
WORKDIR /var/www/html
RUN composer install --no-interaction --prefer-dist --no-dev

# Créer le répertoire pour la base de données
RUN mkdir -p /var/www/html/data && chown -R www-data:www-data /var/www/html/data

# Exposer le port 8080 (c'est celui utilisé par Render)
EXPOSE 8080

# Démarrer Apache
CMD ["apache2-foreground"]
