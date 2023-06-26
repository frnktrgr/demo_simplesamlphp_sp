#!/usr/bin/env bash

SELF=$(basename $0)
_script="$(readlink -f ${BASH_SOURCE[0]})"
_base="$(dirname $_script)"

. "$_base/.helpers.sh"

echogood "Warm up ..."

_term() {
    echoinfo "Caught SIGTERM signal!";
    kill -TERM $child 2>/dev/null
    sleep 2
}

trap _term 15

PHPMEMORYLIMIT="256M"
PHPMAXEXECUTIONTIME="30"

echogood "Setting PHP memory limit to ${PHPMEMORYLIMIT}"
sed "s/^memory_limit = .*$/memory_limit = $PHPMEMORYLIMIT/" -i /etc/php/${BBX_PHP_VERSION}/apache2/php.ini

echogood "Setting PHP max execution time to ${PHPMAXEXECUTIONTIME}"
sed "s/^max_execution_time = .*$/max_execution_time = $PHPMAXEXECUTIONTIME/" -i /etc/php/${BBX_PHP_VERSION}/apache2/php.ini

echogood "Starting Supervisor"
exec /usr/bin/supervisord > /dev/null 2>&1 &
child=$!
wait $child
