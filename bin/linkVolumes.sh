#!/usr/bin/env bash

SELF=$(basename $0)
_script="$(readlink -f ${BASH_SOURCE[0]})"
_base="$(dirname $_script)"
_root="$(dirname $_base)"

. "$_base/.helpers.sh"

cd "$_root" || exit

linkVolume "01_voraussetzungen" "var_log"
linkVolume "02_installation" "var_log"
linkVolume "02_installation" "var_simplesamlphp"
linkVolume "03_konfiguration" "var_log"
linkVolume "03_konfiguration" "var_simplesamlphp"
linkVolume "04_serviceprovider" "var_log"
linkVolume "04_serviceprovider" "var_simplesamlphp"
linkVolume "05_integration" "var_log"
linkVolume "05_integration" "var_simplesamlphp"
linkVolume "06_metarefresh" "var_log"
linkVolume "06_metarefresh" "var_simplesamlphp"
linkVolume "07_authproc" "var_log"
linkVolume "07_authproc" "var_simplesamlphp"
linkVolume "08_production" "var_log"
linkVolume "08_production" "var_simplesamlphp"
linkVolume "09_extras" "var_log"
linkVolume "09_extras" "var_simplesamlphp"
