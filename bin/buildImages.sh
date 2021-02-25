#!/usr/bin/env bash

SELF=$(basename $0)
_script="$(readlink -f ${BASH_SOURCE[0]})"
_base="$(dirname $_script)"
_root="$(dirname $_base)"

. "$_base/.helpers.sh"

cd "$_root" || exit
doandlogpost "docker-compose -f 01_voraussetzungen/docker-compose.yml build"
doandlogpost "docker-compose -f 02_installation/docker-compose.yml build"
doandlogpost "docker-compose -f 03_konfiguration/docker-compose.yml build"
doandlogpost "docker-compose -f 04_serviceprivder/docker-compose.yml build"
doandlogpost "docker-compose -f 05_integration/docker-compose.yml build"
doandlogpost "docker-compose -f 06_metarefresh/docker-compose.yml build"
doandlogpost "docker-compose -f 07_authproc/docker-compose.yml build"
doandlogpost "docker-compose -f 08_production/docker-compose.yml build"
doandlogpost "docker-compose -f 09_extras/docker-compose.yml build"
