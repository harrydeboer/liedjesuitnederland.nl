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
PREFIX="docker exec -it --user=www-data liedjesuitnederland"
if $PREFIX sh -c "test ! -d .git"
then
  docker cp /var/www/liedjesuitnederland.nl/. liedjesuitnederland:/var/www/html
  docker cp /var/www/.ssh liedjesuitnederland:/var/www
else
  $PREFIX git pull origin master
  docker cp /var/www/liedjesuitnederland.nl/.env.local liedjesuitnederland:/var/www/html/.env.local
  docker cp /var/www/liedjesuitnederland.nl/wp-config.php liedjesuitnederland:/var/www/html/wp-config.php
fi
docker system prune -f
