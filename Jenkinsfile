pipeline {
    agent any

    stages {
        // Première étape : Déployer Gstuff-v2
        stage('Deployer Gstuff-v2') {
            steps {
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
            }
        }

        // Deuxième étape : Donner la permission et droit
        stage('Donner la permission et droit') {
            steps {
                echo 'Donner la permission et droit'
                sshPublisher(
                    publishers: [
                        sshPublisherDesc(
                            configName: 'PROJET WASSIM',
                            transfers: [
                                sshTransfer(
                                    execCommand: '/var/www/html/Gstuff-v2/jenkins-pipeline/giveAuthorisation.sh',
                                    remoteDirectory: '/var/www/html/Gstuff-v2/jenkins-pipeline/',
                                    cleanRemote: false,
                                    sourceFiles: ''
                                )
                            ],
                            usePromotionTimestamp: false,
                            useWorkspaceInPromotion: false,
                            verbose: true
                        )
                    ]
                )
            }
        }
    }
}