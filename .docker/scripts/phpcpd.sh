#!/bin/sh
mkdir -p .reports/phpcpd

vendor/bin/phpcpd src/ > .reports/phpcpd/index.html

exit 0