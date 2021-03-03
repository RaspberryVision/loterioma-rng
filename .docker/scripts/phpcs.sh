#!/bin/sh
mkdir -p .reports/phpcs

vendor/bin/phpcs -p --report-full --report-file=.reports/phpcs/index.html --standard=PSR2 src/

exit 0