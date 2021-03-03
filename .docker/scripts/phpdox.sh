#!/bin/sh
mkdir -p .reports/phpdox

vendor/bin/phpdox -f ./../../.reports/config/phpdox.xml

exit 0