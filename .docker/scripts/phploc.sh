#!/bin/sh
mkdir -p .reports/phploc

vendor/bin/phploc src/ > .reports/phploc/index.html

exit 0