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
        stage('analyze') {
            steps {
                sh 'vendor/bin/phpcs -p --report=checkstyle --report-file=`pwd`/reports/checkstyle-result.xml --standard=PSR2 src/ || exit 0'
                sh 'vendor/bin/phpcpd --progress --log-pmd=reports/cpd.xml src/ || exit 0'
                sh 'vendor/bin/pdepend --summary-xml=reports/pdepend.xml --jdepend-chart=reports/jdepend-chart.svg --overview-pyramid=reports/jdepend-overview-pyramid.svg src/'
                sh 'vendor/bin/phpmd src/ xml reports/config/ruleset.xml --ignore-violations-on-exit --reportfile reports/pmd.xml'
                sh 'vendor/bin/phploc --log-xml=reports/phploc.xml --log-csv=reports/phploc.csv src/'
                sh 'vendor/bin/churn run src/ --format json > reports/churn.json'
                sh 'vendor/bin/phpstan analyse --error-format=junit -l 8 src tests > reports/phpstan.xml || exit 0'
                sh 'vendor/bin/psalm > reports/psalm.txt'
            }
        }
        stage('report') {
            steps {
                junit 'reports/*.xml'
                step([
                    $class              : 'CloverPublisher',
                    cloverReportDir     : 'reports',
                    cloverReportFileName: 'clover.xml',
                    healthyTarget: [methodCoverage: 10, conditionalCoverage: 10, statementCoverage: 10],
                    unhealthyTarget: [methodCoverage: 5, conditionalCoverage: 5, statementCoverage: 5],
                    failingTarget: [methodCoverage: 0, conditionalCoverage: 0, statementCoverage: 0],
                ])
                recordIssues enabledForFailure: true, tool: checkStyle(), qualityGates: [[threshold: 10, type: 'TOTAL', unstable: true]], healthy: 10, unhealthy: 100, minimumSeverity: 'HIGH'
                recordIssues enabledForFailure: true, tool: cpd(), qualityGates: [[threshold: 10, type: 'TOTAL', unstable: true]], healthy: 10, unhealthy: 100, minimumSeverity: 'HIGH'
                recordIssues enabledForFailure: true, tool: pmdParser(), qualityGates: [[threshold: 10, type: 'TOTAL', unstable: true]], healthy: 10, unhealthy: 100, minimumSeverity: 'HIGH'
            }
        }
        stage('Yaml linter') {
            steps {
                sh 'vendor/bin/yaml-lint config/services.yaml > reports/yaml-linl.html || exit 0'
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