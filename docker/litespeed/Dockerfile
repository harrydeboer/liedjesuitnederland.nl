FROM litespeedtech/litespeed:6.2.2-lsphp83

RUN apt-get update
RUN DEBIAN_FRONTEND=noninteractive apt-get -y install \
    git \
    nano

COPY ./docker /var/www/html/docker
COPY ./docker/php.ini /usr/local/lsws/lsphp83/etc/php/8.3/mods-available/php.ini
COPY ./docker/litespeed/php-live.ini /usr/local/lsws/lsphp83/etc/php/8.3/mods-available/php-live.ini

RUN rm /usr/local/lsws/lsphp83/etc/php/8.3/mods-available/50-memcached.ini
RUN rm /usr/local/lsws/lsphp83/etc/php/8.3/mods-available/40-msgpack.ini

RUN chown www-data:www-data -R /var/www/html/
