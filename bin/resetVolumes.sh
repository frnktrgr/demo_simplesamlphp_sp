#!/usr/bin/env bash

SELF=$(basename $0)
_script="$(readlink -f ${BASH_SOURCE[0]})"
_base="$(dirname $_script)"
_root="$(dirname $_base)"

. "$_base/.helpers.sh"

cd "$_root" || exit
doandlog "docker volume rm 01_voraussetzungen_var_log"

doandlog "docker volume rm 02_installation_var_log"
doandlog "docker volume rm 02_installation_var_simplesamlphp"

doandlog "docker volume rm 03_konfiguration_var_log"
doandlog "docker volume rm 03_konfiguration_var_simplesamlphp"

doandlog "docker volume rm 04_serviceprovider_var_log"
doandlog "docker volume rm 04_serviceprovider_var_simplesamlphp"

doandlog "docker volume rm 05_integration_var_log"
doandlog "docker volume rm 05_integration_var_simplesamlphp"

doandlog "docker volume rm 06_metarefresh_var_log"
doandlog "docker volume rm 06_metarefresh_var_simplesamlphp"

doandlog "docker volume rm 07_authproc_var_log"
doandlog "docker volume rm 07_authproc_var_simplesamlphp"

doandlog "docker volume rm 08_production_var_log"
doandlog "docker volume rm 08_production_var_simplesamlphp"

doandlog "docker volume rm 09_extras_var_log"
doandlog "docker volume rm 09_extras_var_simplesamlphp"
