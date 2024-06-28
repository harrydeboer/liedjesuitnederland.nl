#!/bin/bash
set -e

if [[ $EUID -eq 0 ]]; then
  echo "This script must NOT be run as root" 1>&2
  exit 1
fi
docker login --username harrydeboer
git pull origin master
docker compose pull
docker compose up -d
docker cp /var/www/letsencrypt liedjesuitnederland:/etc
docker compose restart web
docker system prune -f
