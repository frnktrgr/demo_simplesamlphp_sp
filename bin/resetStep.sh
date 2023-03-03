#!/usr/bin/env bash

SELF=$(basename $0)
_script="$(readlink -f ${BASH_SOURCE[0]})"
_base="$(dirname $_script)"
_root="$(dirname $_base)"

. "$_base/.helpers.sh"

cd "$_root" || exit

folders=($(ls -d "${1}"*))
folder="${folders[0]}"
if [ -f "${folder}/compose.yaml" ]; then
  doandlogpost "docker compose -f ${folder}/compose.yaml down"
  doandlog "docker volume rm ${folder}_var_log"
    if [ "${folder}" != "01_voraussetzungen" ]; then
      doandlog "docker volume rm ${folder}_var_simplesamlphp"
    fi
fi
exit
