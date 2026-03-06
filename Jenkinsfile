pipeline {
    agent any
    stages {
        stage('Test Webhook') {
            steps {
                echo 'Webhook is working! Code received from GitHub.'
                sh 'ls -la'
            }
        }
        stage('Test SSH to Website EC2') {
            steps {
                withCredentials([sshUserPrivateKey(credentialsId: 'website-ssh', keyFileVariable: 'PEM_KEY')]) {
                    sh 'ssh -i $PEM_KEY -o StrictHostKeyChecking=no ubuntu@1.1.1.9 "echo Jenkins successfully SSHed into Website EC2! "'
                }
            }
        }
    }
}



















