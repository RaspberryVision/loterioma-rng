#!/bin/sh
mkdir -p .reports/phpmetrics

vendor/bin/phpmetrics --report-html=.reports/phpmetrics/index.html src/

exit 0