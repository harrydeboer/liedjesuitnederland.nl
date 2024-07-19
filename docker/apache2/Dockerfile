FROM php:8.3-apache

ARG APP_ENV

RUN apt-get update
RUN DEBIAN_FRONTEND=noninteractive apt-get -y install \
    git \
    nano \
    libgmp-dev \
    libxml2-dev \
    libcurl4-openssl-dev \
    libonig-dev \
    libzip-dev \
    libenchant-2-dev \
    libxslt1-dev \
    zip \
    unzip \
    libmagickwand-dev \
    wget

ARG IMAGICK_VERSION=3.7.0

# Imagick is installed from the archive because regular installation fails
# See: https://github.com/Imagick/imagick/issues/643#issuecomment-1834361716
RUN curl -L -o /tmp/imagick.tar.gz https://github.com/Imagick/imagick/archive/refs/tags/${IMAGICK_VERSION}.tar.gz \
    && tar --strip-components=1 -xf /tmp/imagick.tar.gz \
    && phpize \
    && ./configure \
    && make \
    && make install \
    && echo "extension=imagick.so" > /usr/local/etc/php/conf.d/ext-imagick.ini \
    && rm -rf /tmp/* \

ENV APACHE_DOCUMENT_ROOT /var/www/html/sites/liedjesuitnederland.nl/html

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

RUN a2enmod headers rewrite ssl expires

RUN docker-php-ext-install bcmath bz2 calendar curl enchant exif ftp gd gettext gmp intl mbstring mysqli opcache pcntl pdo_mysql soap sockets sysvmsg sysvsem sysvshm xml xsl zip

RUN pecl install redis && docker-php-ext-enable redis
RUN pecl install igbinary && docker-php-ext-enable igbinary

RUN if [ "$APP_ENV" = "dev" ] ; then pecl install xdebug && docker-php-ext-enable xdebug; fi

COPY --from=composer:2.7.7 /usr/bin/composer /usr/bin/composer

COPY ./docker /var/www/html/docker
COPY ./docker/apache2/apache2.conf /etc/apache2/apache2.conf
COPY ./docker/apache2/000-default.${APP_ENV}.conf /etc/apache2/sites-available/000-default.conf
COPY ./docker/php.ini /usr/local/etc/php/conf.d/php.ini

RUN if [ "$APP_ENV" = "dev" ] ; then cp ./docker/apache2/php-dev.ini /usr/local/etc/php/conf.d/php-dev.ini; else \
  cp ./docker/apache2/php-live.ini /usr/local/etc/php/conf.d/php-live.ini; fi

RUN if [ "$APP_ENV" = "dev" ] ; then \
    cp /usr/local/etc/php/php.ini-development /usr/local/etc/php/php.ini;  else \
    cp /usr/local/etc/php/php.ini-production /usr/local/etc/php/php.ini; fi

RUN if [ "$APP_ENV" = "dev" ] ;  \
    then cp /var/www/html/docker/apache2/xdebug.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; fi

RUN chown www-data:www-data -R /var/www/html/

RUN mkdir /var/www/.composer
RUN chown www-data:www-data -R /var/www/.composer
