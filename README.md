<p align="center"><a href="https://supagirl.gstuff.ch/images/logoSupa.png" target="_blank"><img src="https://supagirl.gstuff.ch/images/logoSupa.png" width="400" alt="Laravel Logo"></a></p>

<p align="center">

</p>


## About Gstuff

Gstuff s’écrit avec un G majuscule, en référence à la zone de plaisir appelée point G ou zone G, et signifie donc tout ce qui est en lien avec le plaisir. Dès lors, Gstuff se veut être un site d’annonces érotiques inclusif, c’est-à-dire que seul le plaisir compte, peu importe comment et avec qui, du moment que cela reste entre adultes consentants.

## Prérequis
- composer
- Server php
- Node.js et npm

## Installation

### Cloner le dépôt
```bash
git clone https://github.com/votre-utilisateur/projet-g-plus.git
cd projet-gstuff-v2
```

### Installer les dépendances
```bash
composer install
```

### Installer les dépendance node
```bash
npm install
```
## Lancer le serveur de développement
```bash
php artisan serve
npm run dev
```

## Au déploiements n'oublie pas de charger les dossiers uploade
```bash
php artisan storage:link
```

## Planification des taches

### En local
```bash
php artisan schedule:run
```

### En production (Linux, Unix)
```bash
Ouvrir le crontab : crontab -e
Ajouter la ligne suivante :
* * * * * cd /var/www/supagirl/supagirl-v2 && php artisan stories:delete-expired >> /dev/null 2>&1
#* * * * * cd /var/www/supagirl/supagirl-v2 && php artisan stories:delete-expired >> /home/madadigital/cron.log 2>&1
```

### Configuration de FFmpeg
Initialise le service de gestion des médias avec la configuration appropriée.
Configuration requise :

1. Pour Windows :
    - Télécharger FFmpeg depuis https://ffmpeg.org/download.html
    - Extraire le contenu dans C:\\ffmpeg
    - Ajouter C:\\ffmpeg\\bin aux variables d'environnement PATH
    - Redémarrer l'ordinateur ou la session utilisateur
    - Vérifier l'installation avec `ffmpeg -version` dans CMD

2. Pour Linux (Ubuntu/Debian) :
    ```bash
    # Mettre à jour les paquets
    sudo apt update
    
    # Installer FFmpeg et les dépendances
    sudo apt install -y ffmpeg \
        php-gd \
        php-zip \
        libavcodec-extra \
        libavformat-dev \
        libx264-dev
    
    # Installer PHP-FFMpeg via Composer
    composer require php-ffmpeg/php-ffmpeg
    
    # Vérifier l'installation
    which ffmpeg     # Doit retourner /usr/bin/ffmpeg
    which ffprobe    # Doit retourner /usr/bin/ffprobe
    ```

    3. Vérification de l'environnement :
        - PHP 8.0 ou supérieur requis
        - Extension GD activée (php.ini: extension=gd)
        - Suffisamment d'espace disque pour le traitement des fichiers temporaires
        - Permissions d'écriture sur les dossiers de stockage

## Utilisation
Ouvrez votre navigateur et accédez à http://127.0.0.1:8000 pour voir votre application en action 🎉.


Consultez la documentation de [laravel]([Laravel](https://laravel.com)) pour plus de détails.

## Licence
Ce projet est sous licence MIT. Voir le fichier LICENSE pour plus de détails. Tout droit réserver par [MADA-Digital](https://mada-digital.net)
 😊
