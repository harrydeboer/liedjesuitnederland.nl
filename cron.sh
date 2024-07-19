#!/bin/bash

docker run -t --rm -v /var/www/letsencrypt/certs:/etc/letsencrypt -v /var/www/liedjesuitnederland.nl/sites/liedjesuitnederland.nl/html:/data/letsencrypt certbot/certbot:v1.22.0 certonly --webroot --webroot-path=/data/letsencrypt -n -d liedjesuitnederland.nl -d www.liedjesuitnederland.nl --email info@liedjesuitnederland.nl --agree-tos &&
chown -R www-data:www-data /var/www/letsencrypt &&
sudo -u www-data docker cp /var/www/letsencrypt/certs/archive/liedjesuitnederland.nl/fullchain1.pem liedjesuitnederland:/usr/local/lsws/admin/conf/webadmin.crt &&
sudo -u www-data docker cp /var/www/letsencrypt/certs/archive/liedjesuitnederland.nl/privkey1.pem liedjesuitnederland:/usr/local/lsws/admin/conf/webadmin.key &&
sudo -u www-data docker cp /var/www/letsencrypt/certs/archive/liedjesuitnederland.nl/fullchain1.pem liedjesuitnederland:/usr/local/lsws/admin/conf/cert/admin.crt &&
sudo -u www-data docker cp /var/www/letsencrypt/certs/archive/liedjesuitnederland.nl/privkey1.pem liedjesuitnederland:/usr/local/lsws/admin/conf/cert/admin.key &&
docker exec -t liedjesuitnederland chown -R lsadm:lsadm /usr/local/lsws/admin/conf &&
sudo -u www-data ./bin/acme.sh -D liedjesuitnederland.nl &&
docker restart liedjesuitnederland
