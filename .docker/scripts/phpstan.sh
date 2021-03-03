#!/bin/sh
mkdir -p .reports/phpstan

vendor/bin/phpstan analyse --error-format=raw -l 8 src > .reports/phpstan/index.html

exit 0