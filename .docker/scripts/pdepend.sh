#!/bin/sh
mkdir -p .reports/pdepend

vendor/bin/pdepend src/ > .reports/pdepend/index.html

exit 0