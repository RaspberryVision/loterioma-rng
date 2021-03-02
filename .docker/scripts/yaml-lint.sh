#!/bin/sh
mkdir -p .reports/yaml-lint

vendor/bin/yaml-lint config/services.yaml > .reports/yaml-lint/index.html

exit 0