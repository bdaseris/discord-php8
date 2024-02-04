#!/usr/bin/env bash

set -e

if [ "${1:0:1}" = '-' ]; then
  set -- mysqld "$@"
fi

if [ -f "docker/mysql/entrypoint.sh" ]; then
  exec docker/mysql/entrypoint.sh "$@"
fi
