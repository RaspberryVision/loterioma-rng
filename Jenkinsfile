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
                publishHTMLReport('.reports/yaml-lint', 'index.html', 'Yaml linter')
            }
        }
        stage('Code sniffer') {
            steps {
                sh 'sh .docker/scripts/phpcs.sh'
                publishHTMLReport('.reports/phpcs', 'index.html', 'Code sniffer')
            }
        }
        stage('Code Paste Detector') {
            steps {
                sh 'sh .docker/scripts/phpcpd.sh'
                publishHTMLReport('.reports/phpcpd', 'index.html', 'Code Paste Detector')
            }
        }
        stage('Depend') {
            steps {
                sh 'sh .docker/scripts/pdepend.sh'
                publishHTMLReport('.reports/pdepend', 'index.html', 'PHP Depend')
            }
        }
        stage('Mess Detector') {
            steps {
                sh 'sh .docker/scripts/phpmd.sh'
                publishHTMLReport('.reports/phpmd', 'index.html', 'Mess Detector')
            }
        }
        stage('Stats LOC') {
            steps {
                sh 'sh .docker/scripts/phploc.sh'
                publishHTMLReport('.reports/phploc', 'index.html', 'Stats LOC')
            }
        }
        stage('Churn') {
            steps {
                sh 'sh .docker/scripts/churn.sh'
                publishHTMLReport('.reports/churn', 'index.html', 'Churn')
            }
        }
        stage('PHPStan') {
            steps {
                sh 'sh .docker/scripts/phpstan.sh'
                publishHTMLReport('.reports/phpstan', 'index.html', 'PHPStan')
            }
        }
        stage('Psalm') {
            steps {
                sh 'sh .docker/scripts/psalm.sh'
                publishHTMLReport('.reports/psalm', 'index.html', 'Psalm')
            }
        }
        stage('PHPMetrics') {
            steps {
                sh 'sh .docker/scripts/phpmetrics.sh'
                publishHTMLReport('.reports/phpmetrics', 'index.html', 'PHPMetrics')
            }
        }
        stage('Magic Number Detector') {
            steps {
                sh 'sh .docker/scripts/phpmnd.sh'
                publishHTMLReport('.reports/phpmnd', 'index.html', 'Magic Number Detector')
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
                sh 'vendor/bin/phpstan analyse --error-format=checkstyle -l 8 src > .reports/analyse/phpstan.xml || exit 0'
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
                recordIssues enabledForFailure: true, tool: cpd(pattern: '.reports/analyse/cpd.xml'), qualityGates: [[threshold: 10, type: 'TOTAL', unstable: true]], healthy: 10, unhealthy: 100, minimumSeverity: 'HIGH'
                recordIssues enabledForFailure: true, tool: pmdParser(), qualityGates: [[threshold: 10, type: 'TOTAL', unstable: true]], healthy: 10, unhealthy: 100, minimumSeverity: 'HIGH'
                recordIssues enabledForFailure: true, tool: phpStan(pattern: '.reports/analyse/phpstan.xml'), qualityGates: [[threshold: 10, type: 'TOTAL', unstable: true]], healthy: 10, unhealthy: 100, minimumSeverity: 'HIGH'
            }
        }
        stage('Documentation') {
            steps {
                sh 'vendor/bin/phpdox -f .reports/config/phpdox.xml'
                publishHTMLReport('.reports/phpdox/html', 'index.html', 'Documentation')
            }
        }
    }
}

def publishHTMLReport(reportDir, file, reportName) {
    if (fileExists("${reportDir}/${file}")) {
        publishHTML(target: [
            allowMissing         : true,
            alwaysLinkToLastBuild: true,
            keepAll              : true,
            reportDir            : reportDir,
            reportFiles          : file,
            reportName           : reportName
        ])
    }
}