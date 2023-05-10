#!/usr/bin/env bash

SELF=$(basename $0)
_script="$(readlink -f ${BASH_SOURCE[0]})"
_base="$(dirname $_script)"
_root="$(dirname $_base)"

. "$_base/.helpers.sh"

cd "$_root" || exit

for folder in 01 02 03 04 05 06 07 08 09; do
    ./bin/stopStep.sh $folder
done
exit
