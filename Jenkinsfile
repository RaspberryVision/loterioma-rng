pipeline {
    agent {
        dockerfile {
            dir '.docker/php'
            args '-u root --privileged --entrypoint='
        }
    }

    stages {
        stage('Build') {
            steps {
                echo "Building..."
                sh 'composer install'
            }
        }
        stage('Test') {
            steps {
                echo 'Testing..'
                sh 'php bin/phpunit --log-junit reports/phpunit.xml --coverage-clover reports/clover.xml --coverage-xml reports --coverage-html reports --coverage-crap4j reports/crap4j.xml --whitelist src/ tests'
            }
        }
    }
}