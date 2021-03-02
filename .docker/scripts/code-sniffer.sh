#!/bin/sh
mkdir -p .reports/code-sniffer

vendor/bin/phpcs -p --report=checkstyle --report-file=.reports/code-sniffer/checkstyle-result.xml --standard=PSR2 src/

exit 0