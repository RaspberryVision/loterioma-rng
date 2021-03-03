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
        stage('Yaml linter') {
            steps {
                sh 'sh .docker/scripts/yaml-lint.sh'
                publishHTML (target: [
                    allowMissing: false,
                    alwaysLinkToLastBuild: false,
                    keepAll: true,
                    reportDir: '.reports/yaml-lint/',
                    reportFiles: 'index.html',
                    reportName: 'Yaml Lint'
                ])
            }
        }
        stage('Code sniffer') {
            steps {
                sh 'sh .docker/scripts/phpcs.sh'
                publishHTML (target: [
                    allowMissing: false,
                    alwaysLinkToLastBuild: false,
                    keepAll: true,
                    reportDir: '.reports/phpcs/',
                    reportFiles: 'index.html',
                    reportName: 'Code sniffer'
                ])
            }
        }
        stage('Code Paste Detector') {
            steps {
                sh 'sh .docker/scripts/phpcpd.sh'
                publishHTML (target: [
                    allowMissing: false,
                    alwaysLinkToLastBuild: false,
                    keepAll: true,
                    reportDir: '.reports/phpcpd/',
                    reportFiles: 'index.html',
                    reportName: 'Code Paste Detector'
                ])
            }
        }
        stage('PHP Depend') {
            steps {
                sh 'sh .docker/scripts/pdepend.sh'
                publishHTML (target: [
                    allowMissing: false,
                    alwaysLinkToLastBuild: false,
                    keepAll: true,
                    reportDir: '.reports/pdepend/',
                    reportFiles: 'index.html',
                    reportName: 'Code sniffer'
                ])
            }
        }
        stage('Mess Detector') {
            steps {
                sh 'sh .docker/scripts/phpmd.sh'
                publishHTML (target: [
                    allowMissing: false,
                    alwaysLinkToLastBuild: false,
                    keepAll: true,
                    reportDir: '.reports/phpmd/',
                    reportFiles: 'index.html',
                    reportName: 'Mess Detector'
                ])
            }
        }
        stage('Code stats') {
            steps {
                sh 'sh .docker/scripts/phploc.sh'
                publishHTML (target: [
                    allowMissing: false,
                    alwaysLinkToLastBuild: false,
                    keepAll: true,
                    reportDir: '.reports/phploc/',
                    reportFiles: 'index.html',
                    reportName: 'Code Stats (LOC)'
                ])
            }
        }
//         stage('Churn') {
//             steps {
//                 sh 'sh .docker/scripts/churn.sh'
//                 publishHTML (target: [
//                     allowMissing: false,
//                     alwaysLinkToLastBuild: false,
//                     keepAll: true,
//                     reportDir: '.reports/churn/',
//                     reportFiles: 'index.html',
//                     reportName: 'Churn'
//                 ])
//             }
//         }
        stage('PHPStan') {
            steps {
                sh 'sh .docker/scripts/phpstan.sh'
                publishHTML (target: [
                    allowMissing: false,
                    alwaysLinkToLastBuild: false,
                    keepAll: true,
                    reportDir: '.reports/phpstan/',
                    reportFiles: 'index.html',
                    reportName: 'PHPStan'
                ])
            }
        }
        stage('Psalm') {
            steps {
                sh 'sh .docker/scripts/psalm.sh'
                publishHTML (target: [
                    allowMissing: false,
                    alwaysLinkToLastBuild: false,
                    keepAll: true,
                    reportDir: '.reports/psalm/',
                    reportFiles: 'index.html',
                    reportName: 'PHPStan'
                ])
            }
        }
        stage('analyze') {
            steps {
                sh 'mkdir -p .reports/analyse'
                sh 'vendor/bin/phpcs -p --report=checkstyle --report-file=.reports/analyse/checkstyle-result.xml --standard=PSR2 src/ || exit 0'
                sh 'vendor/bin/phpcpd --progress --log-pmd=.reports/analyse/cpd.xml src/ || exit 0'
                sh 'vendor/bin/pdepend --summary-xml=.reports/analyse/pdepend.xml --jdepend-chart=.reports/analyse/jdepend-chart.svg --overview-pyramid=.reports/analyse/jdepend-overview-pyramid.svg src/'
                sh 'vendor/bin/phpmd src/ xml .reports/config/ruleset.xml --ignore-violations-on-exit --reportfile .reports/analyse/pmd.xml'
                sh 'vendor/bin/phploc --log-xml=.reports/analyse/phploc.xml --log-csv=.reports/analyse/phploc.csv src/'
                sh 'vendor/bin/phpstan analyse --error-format=xml -l 8 src || exit 0'
            }
        }
        stage('report') {
            steps {
                junit '.reports/analyse/*.xml'
                step([
                    $class              : 'CloverPublisher',
                    cloverReportDir     : '.reports/analyse/',
                    cloverReportFileName: 'clover.xml',
                    healthyTarget: [methodCoverage: 10, conditionalCoverage: 10, statementCoverage: 10],
                    unhealthyTarget: [methodCoverage: 5, conditionalCoverage: 5, statementCoverage: 5],
                    failingTarget: [methodCoverage: 0, conditionalCoverage: 0, statementCoverage: 0],
                ])
                recordIssues enabledForFailure: true, tool: checkStyle(), qualityGates: [[threshold: 10, type: 'TOTAL', unstable: true]], healthy: 10, unhealthy: 100, minimumSeverity: 'HIGH'
                recordIssues enabledForFailure: true, tool: cpd(), qualityGates: [[threshold: 10, type: 'TOTAL', unstable: true]], healthy: 10, unhealthy: 100, minimumSeverity: 'HIGH'
                recordIssues enabledForFailure: true, tool: pmdParser(), qualityGates: [[threshold: 10, type: 'TOTAL', unstable: true]], healthy: 10, unhealthy: 100, minimumSeverity: 'HIGH'
                recordIssues enabledForFailure: true, tool: phpStan(), qualityGates: [[threshold: 10, type: 'TOTAL', unstable: true]], healthy: 10, unhealthy: 100, minimumSeverity: 'HIGH'
            }
        }
        stage('Documentation') {
            steps {
                sh 'vendor/bin/phpdox -f .reports/config/phpdox.xml'
                publishHTML (target: [
                    allowMissing: false,
                    alwaysLinkToLastBuild: false,
                    keepAll: true,
                    reportDir: '.reports/phpdox/html',
                    reportFiles: 'index.html',
                    reportName:'PHPDox Documentation'
                ])
            }
        }

//         stage('Test') {
//             steps {
//                 echo 'Testing..'
//                 sh 'php bin/phpunit --log-junit reports/phpunit.xml --coverage-clover reports/clover.xml --coverage-xml reports --coverage-html reports --coverage-crap4j reports/crap4j.xml --whitelist src/ tests'
//             }
//         }
    }
}