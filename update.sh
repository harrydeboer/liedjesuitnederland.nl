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
docker cp /var/www/letsencrypt/certs/archive/liedjesuitnederland.nl/fullchain1.pem liedjesuitnederland:/usr/local/lsws/admin/conf/webadmin.crt
docker cp /var/www/letsencrypt/certs/archive/liedjesuitnederland.nl/privkey1.pem liedjesuitnederland:/usr/local/lsws/admin/conf/webadmin.key
docker cp /var/www/letsencrypt/certs/archive/liedjesuitnederland.nl/fullchain1.pem liedjesuitnederland:/usr/local/lsws/admin/conf/cert/admin.crt
docker cp /var/www/letsencrypt/certs/archive/liedjesuitnederland.nl/privkey1.pem liedjesuitnederland:/usr/local/lsws/admin/conf/cert/admin.key
docker exec -t liedjesuitnederland chown -R lsadm:lsadm /usr/local/lsws/admin/conf
rm -r sites/lscache
mkdir sites/lscache
docker compose restart litespeed
docker system prune -f
