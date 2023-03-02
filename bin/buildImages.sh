#!/usr/bin/env bash

SELF=$(basename $0)
_script="$(readlink -f ${BASH_SOURCE[0]})"
_base="$(dirname $_script)"
_root="$(dirname $_base)"

. "$_base/.helpers.sh"

cd "$_root" || exit
doandlogpost "docker compose -f 01_voraussetzungen/compose.yaml build"
doandlogpost "docker compose -f 02_installation/compose.yaml build"
doandlogpost "docker compose -f 03_konfiguration/compose.yaml build"
doandlogpost "docker compose -f 04_serviceprivder/compose.yaml build"
doandlogpost "docker compose -f 05_integration/compose.yaml build"
doandlogpost "docker compose -f 06_metarefresh/compose.yaml build"
doandlogpost "docker compose -f 07_authproc/compose.yaml build"
doandlogpost "docker compose -f 08_production/compose.yaml build"
doandlogpost "docker compose -f 09_extras/compose.yaml build"
