#!/bin/bash

# Naviguer vers le répertoire du projet
cd /var/www/html/Gstuff-v2 || { echo "Échec de la navigation vers /var/www/html/Gstuff-v2"; exit 1; }

# Créer les répertoires nécessaires s'ils n'existent pas
mkdir -p /var/www/html/Gstuff-v2/bootstrap/cache
mkdir -p /var/www/html/Gstuff-v2/storage/framework/{cache,sessions,views}

# Configurer les permissions
sudo chown -R www-data:www-data /var/www/html/Gstuff-v2 || { echo "Échec de la modification des propriétaires"; exit 1; }
sudo chmod -R 755 /var/www/html/Gstuff-v2 || { echo "Échec de la modification des permissions"; exit 1; }
sudo chmod -R 775 /var/www/html/Gstuff-v2/storage /var/www/html/Gstuff-v2/bootstrap/cache || { echo "Échec de la modification des permissions pour storage et cache"; exit 1; }

# Installer les dépendances Composer (en tant qu'utilisateur www-data pour éviter les avertissements de sécurité)
sudo -u www-data composer install --no-dev --optimize-autoloader || { echo "Échec de l'installation des dépendances Composer"; exit 1; }

# Installer les dépendances NPM et compiler les assets
npm install --production || { echo "Échec de l'installation des dépendances NPM"; exit 1; }
npm run build || { echo "Échec de la compilation des assets"; exit 1; }

# Créer le fichier .env et générer la clé d'application
if [ ! -f .env ]; then
    cp .env.example .env || { echo "Échec de la copie du fichier .env"; exit 1; }
fi
sudo -u www-data php artisan key:generate || { echo "Échec de la génération de la clé d'application"; exit 1; }

# Mettre en cache la configuration, les routes et les vues
sudo -u www-data php artisan config:cache || { echo "Échec de la mise en cache de la configuration"; exit 1; }
sudo -u www-data php artisan route:cache || { echo "Échec de la mise en cache des routes"; exit 1; }
sudo -u www-data php artisan view:cache || { echo "Échec de la mise en cache des vues"; exit 1; }

echo "Déploiement terminé avec succès."