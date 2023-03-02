#!/usr/bin/env bash

SELF=$(basename $0)
_script="$(readlink -f ${BASH_SOURCE[0]})"
_base="$(dirname $_script)"
_root="$(dirname $_base)"

. "$_base/.helpers.sh"

#_volbase="/var/lib/docker"

# https://docs.docker.com/engine/security/userns-remap/ variant
_volbase="/var/lib/docker/10000000.10000000"
sudoandlog "setfacl -m u:${USER}:rwx /var/lib/docker /var/lib/docker/10000000.10000000 /var/lib/docker/10000000.10000000/volumes"

cd "$_root" || exit

doandlog "mkdir -p 01_voraussetzungen/volumes"
doandlog "cp bin/voltemplate.gitignore 01_voraussetzungen/volumes/.gitignore"
doandlog "rm -f 01_voraussetzungen/volumes/var_log"
doandlog "ln -f -s ${_volbase}/volumes/01_voraussetzungen_var_log/_data 01_voraussetzungen/volumes/var_log"
sudoandlog "setfacl -R -m u:${USER}:rwx 01_voraussetzungen/volumes/var_log/"

doandlog "mkdir -p 02_installation/volumes"
doandlog "cp bin/voltemplate.gitignore 02_installation/volumes/.gitignore"
doandlog "rm -f 02_installation/volumes/var_log"
doandlog "ln -f -s ${_volbase}/volumes/02_installation_var_log/_data 02_installation/volumes/var_log"
sudoandlog "setfacl -R -m u:${USER}:rwx 02_installation/volumes/var_log/"
doandlog "rm -f 02_installation/volumes/var_simplesamlphp"
doandlog "ln -f -s ${_volbase}/volumes/02_installation_var_simplesamlphp/_data 02_installation/volumes/var_simplesamlphp"
sudoandlog "setfacl -R -m u:${USER}:rwx 02_installation/volumes/var_simplesamlphp/"

doandlog "mkdir -p 03_konfiguration/volumes"
doandlog "cp bin/voltemplate.gitignore 03_konfiguration/volumes/.gitignore"
doandlog "rm -f 03_konfiguration/volumes/var_log"
doandlog "ln -f -s ${_volbase}/volumes/03_konfiguration_var_log/_data 03_konfiguration/volumes/var_log"
sudoandlog "setfacl -R -m u:${USER}:rwx 03_konfiguration/volumes/var_log/"
doandlog "rm -f 03_konfiguration/volumes/var_simplesamlphp"
doandlog "ln -f -s ${_volbase}/volumes/03_konfiguration_var_simplesamlphp/_data 03_konfiguration/volumes/var_simplesamlphp"
sudoandlog "setfacl -R -m u:${USER}:rwx 03_konfiguration/volumes/var_simplesamlphp/"

doandlog "mkdir -p 04_serviceprovider/volumes"
doandlog "cp bin/voltemplate.gitignore 04_serviceprovider/volumes/.gitignore"
doandlog "rm -f 04_serviceprovider/volumes/var_log"
doandlog "ln -f -s ${_volbase}/volumes/04_serviceprovider_var_log/_data 04_serviceprovider/volumes/var_log"
sudoandlog "setfacl -R -m u:${USER}:rwx 04_serviceprovider/volumes/var_log/"
doandlog "rm -f 04_serviceprovider/volumes/var_simplesamlphp"
doandlog "ln -f -s ${_volbase}/volumes/04_serviceprovider_var_simplesamlphp/_data 04_serviceprovider/volumes/var_simplesamlphp"
sudoandlog "setfacl -R -m u:${USER}:rwx 04_serviceprovider/volumes/var_simplesamlphp/"

doandlog "mkdir -p 05_integration/volumes"
doandlog "cp bin/voltemplate.gitignore 05_integration/volumes/.gitignore"
doandlog "rm -f 05_integration/volumes/var_log"
doandlog "ln -f -s ${_volbase}/volumes/05_integration_var_log/_data 05_integration/volumes/var_log"
sudoandlog "setfacl -R -m u:${USER}:rwx 05_integration/volumes/var_log/"
doandlog "rm -f 05_integration/volumes/var_simplesamlphp"
doandlog "ln -f -s ${_volbase}/volumes/05_integration_var_simplesamlphp/_data 05_integration/volumes/var_simplesamlphp"
sudoandlog "setfacl -R -m u:${USER}:rwx 05_integration/volumes/var_simplesamlphp/"

doandlog "mkdir -p 06_metarefresh/volumes"
doandlog "cp bin/voltemplate.gitignore 06_metarefresh/volumes/.gitignore"
doandlog "rm -f 06_metarefresh/volumes/var_log"
doandlog "ln -f -s ${_volbase}/volumes/06_metarefresh_var_log/_data 06_metarefresh/volumes/var_log"
sudoandlog "setfacl -R -m u:${USER}:rwx 06_metarefresh/volumes/var_log/"
doandlog "rm -f 06_metarefresh/volumes/var_simplesamlphp"
doandlog "ln -f -s ${_volbase}/volumes/06_metarefresh_var_simplesamlphp/_data 06_metarefresh/volumes/var_simplesamlphp"
sudoandlog "setfacl -R -m u:${USER}:rwx 06_metarefresh/volumes/var_simplesamlphp/"

doandlog "mkdir -p 07_authproc/volumes"
doandlog "cp bin/voltemplate.gitignore 07_authproc/volumes/.gitignore"
doandlog "rm -f 07_authproc/volumes/var_log"
doandlog "ln -f -s ${_volbase}/volumes/07_authproc_var_log/_data 07_authproc/volumes/var_log"
sudoandlog "setfacl -R -m u:${USER}:rwx 07_authproc/volumes/var_log/"
doandlog "rm -f 07_authproc/volumes/var_simplesamlphp"
doandlog "ln -f -s ${_volbase}/volumes/07_authproc_var_simplesamlphp/_data 07_authproc/volumes/var_simplesamlphp"
sudoandlog "setfacl -R -m u:${USER}:rwx 07_authproc/volumes/var_simplesamlphp/"

doandlog "mkdir -p 08_production/volumes"
doandlog "cp bin/voltemplate.gitignore 08_production/volumes/.gitignore"
doandlog "rm -f 08_production/volumes/var_log"
doandlog "ln -f -s ${_volbase}/volumes/08_production_var_log/_data 08_production/volumes/var_log"
sudoandlog "setfacl -R -m u:${USER}:rwx 08_production/volumes/var_log/"
doandlog "rm -f 08_production/volumes/var_simplesamlphp"
doandlog "ln -f -s ${_volbase}/volumes/08_production_var_simplesamlphp/_data 08_production/volumes/var_simplesamlphp"
sudoandlog "setfacl -R -m u:${USER}:rwx 08_production/volumes/var_simplesamlphp/"

doandlog "mkdir -p 09_extras/volumes"
doandlog "cp bin/voltemplate.gitignore 09_extras/volumes/.gitignore"
doandlog "rm -f 09_extras/volumes/var_log"
doandlog "ln -f -s ${_volbase}/volumes/09_extras_var_log/_data 09_extras/volumes/var_log"
sudoandlog "setfacl -R -m u:${USER}:rwx 09_extras/volumes/var_log/"
doandlog "rm -f 09_extras/volumes/var_simplesamlphp"
doandlog "ln -f -s ${_volbase}/volumes/09_extras_var_simplesamlphp/_data 09_extras/volumes/var_simplesamlphp"
sudoandlog "setfacl -R -m u:${USER}:rwx 09_extras/volumes/var_simplesamlphp/"
