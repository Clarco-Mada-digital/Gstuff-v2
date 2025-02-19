#!/bin/bash

# Naviguer vers le répertoire du projet
cd /var/www/html/Gstuff-v2 || exit 1

# Installer les dépendances Composer
composer install --no-dev --optimize-autoloader || exit 1

# Installer les dépendances NPM et compiler les assets
npm install --production || exit 1
npm run build || exit 1

# Configurer les permissions
sudo chown -R www-data:www-data /var/www/html/Gstuff-v2 || exit 1
sudo chmod -R 755 /var/www/html/Gstuff-v2 || exit 1
sudo chmod -R 775 /var/www/html/Gstuff-v2/storage || exit 1
sudo chmod -R 775 /var/www/html/Gstuff-v2/bootstrap/cache || exit 1

# Créer le fichier .env et générer la clé d'application
cp .env.example .env || exit 1
php artisan key:generate || exit 1

# Mettre en cache la configuration, les routes et les vues
php artisan config:cache || exit 1
php artisan route:cache || exit 1
php artisan view:cache || exit 1

echo "Déploiement terminé avec succès."