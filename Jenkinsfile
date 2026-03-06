pipeline {
    agent any

environment {
    WEBSITE_IP = '1.1.1.9'
    WEBSITE_USER = 'ubuntu'
    NGINX_ROOT = '/var/www/html/anantglobal'
    BACKUP_DIR = '/var/www/html/backup'
}

    stages {

        stage('Checkout') {
            steps {
                echo 'Pulling latest code from GitHub...'
                checkout scm
            }
        }

        stage('Backup') {
            steps {
                echo 'Backing up current live files...'
                withCredentials([sshUserPrivateKey(credentialsId: 'website-ssh', keyFileVariable: 'PEM_KEY')]) {
                    sh '''
                        ssh -i $PEM_KEY -o StrictHostKeyChecking=no $WEBSITE_USER@$WEBSITE_IP \
                        "sudo mkdir -p $BACKUP_DIR && \
                        sudo cp -r $NGINX_ROOT $BACKUP_DIR/backup_\$(date +%Y%m%d_%H%M%S)"
                    '''
                }
            }
        }

        stage('Deploy') {
            steps {
                echo 'Deploying new files to Website EC2...'
                withCredentials([sshUserPrivateKey(credentialsId: 'website-ssh', keyFileVariable: 'PEM_KEY')]) {
                    sh '''
                        rsync -avz --delete \
                        -e "ssh -i $PEM_KEY -o StrictHostKeyChecking=no" \
                        --exclude='Jenkinsfile' \
                        --exclude='.git' \
                        ./ $WEBSITE_USER@$WEBSITE_IP:$NGINX_ROOT/
                    '''
                }
            }
        }

        stage('Verify') {
            steps {
                echo 'Verifying Nginx is running...'
                withCredentials([sshUserPrivateKey(credentialsId: 'website-ssh', keyFileVariable: 'PEM_KEY')]) {
                    sh '''
                        ssh -i $PEM_KEY -o StrictHostKeyChecking=no $WEBSITE_USER@$WEBSITE_IP \
                        "systemctl is-active nginx && curl -o /dev/null -s -w '%{http_code}' http://localhost"
                    '''
                }
            }
        }

    }

    post {
        success {
            echo ' Deployment successful! anantglobal.in is live.'
        }
        failure {
            echo ' Deployment failed! Check the logs above.'
        }
    }
}