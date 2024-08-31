pipeline {
    agent any
    stages {
        stage("Install Node") {
            steps {
                sh '/var/lib/jenkins/scripts/nodejs_via_nvm_in_jenkins.sh'
            }
        }
        stage("Build") {
            environment {
                LOQUI_DB = credentials("LOQUI_DB")
            }
            steps {
               
                git branch: 'main',
                    credentialsId: 'agent-key',
                    url: 'git@github.com:Loqui-Project/loqui.git'
                sh 'php --version'
                sh 'composer install'
                sh 'composer --version'
                sh 'cp .env.example .env'
                sh 'echo DB_HOST=localhost >> .env'
                sh 'echo APP_DEBUG=false >> .env'
                sh 'echo DB_USERNAME=${LOQUI_DB_USR} >> .env'
                sh 'echo DB_DATABASE=loqui_backend >> .env'
                sh 'echo DB_PASSWORD=${LOQUI_DB_PSW} >> .env'
                sh 'php artisan key:generate'
                sh 'cp .env .env.testing'
                sh 'php artisan migrate'
                nodejs(nodeJSInstallationName: 'LTS') {
                    sh 'pnpm --version'
                    sh 'pnpm install'
                    sh 'pnpm run build'
                }
                sh 'sudo service nginx restart'
            }
        }
        stage("Unit test") {
            steps {
                sh 'php artisan test'
            }
        }
        stage("Code coverage") {
            steps {
                sh "vendor/bin/pest --coverage-html 'reports/coverage'"
            }
        }

    }
}