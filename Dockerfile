FROM php:7.4-apache

# Installer les dépendances système
RUN apt-get update && apt-get install -y \
    sqlite3 \
    libsqlite3-dev \
    build-essential \
    && rm -rf /var/lib/apt/lists/*

# Installer les extensions PHP
RUN docker-php-ext-install pdo_sqlite

# Activer mod_rewrite
RUN a2enmod rewrite

# Copier le code source
COPY . /var/www/html

# Installer Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Installer les dépendances PHP
WORKDIR /var/www/html
RUN composer install --no-interaction --prefer-dist --no-dev

# Permissions correctes
RUN chown -R www-data:www-data /var/www/html && \
    chmod -R 755 /var/www/html

# Créer répertoire données
RUN mkdir -p /var/www/html/data && \
    chown -R www-data:www-data /var/www/html/data

# CRITICAL: Configurer Apache pour servir depuis public/ avec DocumentRoot correct
RUN cat > /etc/apache2/sites-available/000-default.conf <<'EOF'
<VirtualHost *:80>
    ServerAdmin admin@localhost
    DocumentRoot /var/www/html/public

    <Directory /var/www/html/public>
        Options FollowSymLinks
        AllowOverride All
        Require all granted

        RewriteEngine On
        RewriteBase /
        RewriteCond %{REQUEST_FILENAME} !-f
        RewriteCond %{REQUEST_FILENAME} !-d
        RewriteRule ^(.*)$ index.php [QSA,L]
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/error.log
    CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
EOF

EXPOSE 80

CMD ["apache2-foreground"]
