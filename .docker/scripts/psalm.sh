#!/bin/sh
mkdir -p .reports/psalm

vendor/bin/psalm > .reports/psalm/index.html

exit 0