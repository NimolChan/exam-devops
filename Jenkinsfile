pipeline {
    agent any

    triggers {
        pollSCM('H/5 * * * *')
    }

    environment {
        EMAIL = 'srengty@gmail.com'
    }

    stages {
        stage('Checkout') {
            steps {
                git branch: 'main', credentialsId: 'sumu', url: 'https://github.com/NimolChan/exam-devops.git'
            }
        }

        stage('Test') {
            steps {
                sh 'php artisan test'
            }
        }

        stage('Build') {
            steps {
                sh 'composer install'
                sh 'npm install && npm run build'
            }
        }

        stage('Deploy') {
            steps {
                sh 'ansible-playbook -i inventory.ini deploy.yml'
            }
        }
    }

    post {
        failure {
            mail bcc: "",
                 to: "srengty@gmail.com",
                 subject: "Build Failed: ${env.JOB_NAME} #${env.BUILD_NUMBER}",
                 body: "Check Jenkins for build failure logs."
        }
    }
}
