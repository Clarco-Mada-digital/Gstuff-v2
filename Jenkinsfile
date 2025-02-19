pipeline {
    agent any

    stages {
        stage('Deployer Gstuff-v2') {
            steps {
                // Étape 1 : Déployer les fichiers via SSH
                sshPublisher(
                    publishers: [
                        sshPublisherDesc(
                            configName: 'Gstuff-v2',
                            transfers: [
                                sshTransfer(
                                    cleanRemote: false,
                                    excludes: '',
                                    execCommand: '',
                                    execTimeout: 120000,
                                    flatten: false,
                                    makeEmptyDirs: false,
                                    noDefaultExcludes: false,
                                    patternSeparator: '[, ]+',
                                    remoteDirectory: '/var/www/html/Gstuff-v2',
                                    remoteDirectorySDF: false,
                                    removePrefix: '',
                                    sourceFiles: '**/*'
                                )
                            ],
                            usePromotionTimestamp: false,
                            useWorkspaceInPromotion: false,
                            verbose: false
                        )
                    ]
                )

                // Étape 2 : Exécuter les commandes SSH pour configurer le projet
                script {
                    def remoteCommands = '''
                        cd /var/www/html/Gstuff-v2
                        composer install --no-dev --optimize-autoloader
                        npm install --production
                        npm run build
                        sudo chown -R www-data:www-data /var/www/html/Gstuff-v2
                        sudo chmod -R 755 /var/www/html/Gstuff-v2
                        sudo chmod -R 775 /var/www/html/Gstuff-v2/storage
                        sudo chmod -R 775 /var/www/html/Gstuff-v2/bootstrap/cache
                        cp .env.example .env
                        php artisan key:generate
                        php artisan config:cache
                        php artisan route:cache
                        php artisan view:cache
                    '''
                    sshPublisher(
                        publishers: [
                            sshPublisherDesc(
                                configName: 'Gstuff-v2',
                                transfers: [
                                    sshTransfer(
                                        execCommand: remoteCommands
                                    )
                                ]
                            )
                        ]
                    )
                }
            }
        }
    }
}