#!/bin/sh
mkdir -p .reports/phpmd

vendor/bin/phpmd src/ html .reports/config/ruleset.xml > .reports/phpmd/index.html

exit 0