#!/usr/bin/env bash

_self=$(basename $0)
_script="$(readlink -f ${BASH_SOURCE[0]})"
_base="$(dirname $_script)"
_gitbase="$(dirname $_base)"

optbase="/opt/rrze/apps/devssp"

GREEN="\e[00;32m"
YELLOW="\e[00;33m"
RED="\e[00;31m"
RESET="\e[00m"
FANCYX='\xe2\x98\x93' #'\x26\x13' #nice x UTF-8
CHECKMARK='\xe2\x9c\x93' #'\x27\x13' #checkmark UTF-8

function geticon {
  local MY_ICON=$(echo -ne "$1")
  echo -ne "$2$MY_ICON$RESET"
}
function echogood {
  echo -e "DEVSSP: $GREEN$1$RESET"
}
function echoinfo {
  echo -e "DEVSSP: $YELLOW$1$RESET"
}
function echobad {
  echo -e "DEVSSP: $RED$1$RESET" >&2
}

function andlog() {
  exitcode=$?
  #echo $exitcode
  exec 3>&- # Close FD #3.
  # Or this alternative, which captures stderr, letting stdout through:
  #{ output=$(command 2>&1 1>&3-) ; } 3>&1
  if [ "$exitcode" -ne "0" ]; then
    #echo -ne "${RED}FAILED$RESET"
    geticon $FANCYX $RED
    echo
    echo $output
  else
    #echo -ne "${GREEN}DONE$RESET"
    geticon $CHECKMARK $GREEN
    echo
  fi
}

function sudoandlog() {
  printf "DEVSSP sudo: $RESET$1 ... "
  exec 3>&1 # Save the place that stdout (1) points to.
  if [ -t 0 ]; then
    output=$(sudo env "PATH=$PATH" $1 2>&1 1>&3)
  else
    output=$(gksudo -- sudo env "PATH=$PATH" $1 2>&1 1>&3)
  fi
  andlog
}

function doandlog() {
  printf "DEVSSP: $RESET$1 ... "
  exec 3>&1 # Save the place that stdout (1) points to.
  output=$($1 2>&1 1>&3)
  andlog
}

function doandlogpost() {
  echo -e "DEVSSP: $RESET$1 ... "
  exec 3>&1 # Save the place that stdout (1) points to.
  output=$($1 2>&1 1>&3)
  printf "DEVSSP: $RESET$1 ... "
  andlog
}

function changeHosts() {
  if [ -e "${HOME}/.ddk-hosts/default" ] ;then
    if [ -e "${1}" ]; then
      sudo cp "${1}" /etc/hosts
      echogood "new /etc/hosts: ${1}"
    else
      echobad "$1 not found"
    fi
  else
    echobad "no default hostfile found, in order to damage your /etc/hosts ..."
    echoinfo "setup your default hostfile first - something like:"
    echoinfo "mkdir -p ~/.ddk-hosts && cp /etc/hosts ~/.ddk-hosts/default"
  fi
}

function resetHosts() {
  if [ -e "${HOME}/.ddk-hosts/default" ] ;then
    sudo cp "${HOME}/.ddk-hosts/default" /etc/hosts
    echogood "reset /etc/hosts to default"
  else
    echobad "no default hostfile found, in order to damage your /etc/hosts ..."
    echoinfo "setup your default hostfile first - something like:"
    echoinfo "mkdir -p ~/.ddk-hosts && cp /etc/hosts ~/.ddk-hosts/default"
  fi
}
