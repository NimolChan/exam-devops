pipeline {
    agent any

    // 🔄 Automatically check Git every 5 minutes
    triggers {
        pollSCM('H/5 * * * *')
    }

    environment {
        // Customize these if needed
        DEPLOY_SERVER = '192.168.1.100' // your server IP
        DEPLOY_USER = 'ubuntu'          // your SSH user
        DEPLOY_DIR = '/var/www/exam-devops'
    }

    stages {
        stage('Checkout Code') {
            steps {
                echo "📥 Cloning repository..."
                checkout scm
            }
        }

        stage('Install & Build') {
            steps {
                echo "📦 Installing dependencies..."
                sh 'npm install'    // for Laravel: `composer install`
            }
        }

        stage('Run Tests') {
            steps {
                echo "🧪 Running tests..."
                sh 'npm run test'   // for Laravel: `php artisan test`
            }
        }

        stage('Deploy via Ansible') {
            when {
                expression { currentBuild.currentResult == 'SUCCESS' }
            }
            steps {
                echo "🚀 Running Ansible Playbook..."
                sh 'ansible-playbook -i inventory deploy.yml'
            }
        }
    }

    post {
        failure {
            echo "❌ Build failed. Sending notification email..."
            script {
                emailext(
                    subject: "❌ BUILD FAILED: ${env.JOB_NAME} #${env.BUILD_NUMBER}",
                    body: """
                        <p>Build failed for <b>${env.JOB_NAME}</b> #${env.BUILD_NUMBER}</p>
                        <p>Check the logs: <a href="${env.BUILD_URL}">${env.BUILD_URL}</a></p>
                    """,
                    mimeType: 'text/html',
                    to: "srengty@gmail.com",
                    recipientProviders: [developers(), culprits()]
                )
            }
        }
        success {
            echo "✅ Build and deployment completed successfully!"
        }
    }
}
