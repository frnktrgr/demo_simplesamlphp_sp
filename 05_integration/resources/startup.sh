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

echogood "Starting Supervisor"
exec /usr/bin/supervisord > /dev/null 2>&1 &
child=$!
wait $child
