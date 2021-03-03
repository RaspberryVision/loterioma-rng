#!/bin/sh
mkdir -p .reports/churn

echo vendor/bin/churn run src/ --format json > .reports/churn/index.html

exit 0