#!/bin/sh
mkdir -p .reports/phpmnd

vendor/bin/phpmnd src --ignore-numbers=2,-1 --ignore-funcs=round,sleep --exclude=tests --progress --extensions=default_parameter,-return,argument > .reports/phpmnd/index.html

exit 0