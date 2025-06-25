pipeline {
    agent any

    triggers {
        pollSCM('H/5 * * * *') // Poll every 5 minutes
    }

    environment {
        DEPLOY_SERVER = 'user@your-server-ip'
    }

    stages {
        stage('Clone') {
            steps {
                checkout scm
            }
        }

        stage('Build & Test') {
            steps {
                echo "Running tests..."
                sh 'npm install'        // or 'composer install' / 'mvn test'
                sh 'npm run test'       // or 'php artisan test'
            }
        }

        stage('Deploy via Ansible') {
            when {
                expression { currentBuild.currentResult == 'SUCCESS' }
            }
            steps {
                echo "Running Ansible Playbook..."
                sh 'ansible-playbook -i inventory deploy.yml'
            }
        }
    }

    post {
        failure {
            script {
                emailext(
                    subject: "BUILD FAILED: ${env.JOB_NAME} [${env.BUILD_NUMBER}]",
                    body: "Build failed. Check: ${env.BUILD_URL}",
                    recipientProviders: [developers(), culprits()],
                    to: 'srengty@gmail.com'
                )
            }
        }
        success {
            echo "Build succeeded and deployed"
        }
    }
}
