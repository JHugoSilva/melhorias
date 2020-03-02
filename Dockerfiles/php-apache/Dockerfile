FROM php:5.6-apache

RUN apt-get update && \
  apt-get install -y libpq-dev libxml2-dev libcurl4-openssl-dev libmcrypt-dev curl libbz2-dev libpng-dev libfreetype6-dev libgd-dev

RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql
RUN docker-php-ext-install pdo \
  pdo_pgsql \
  pgsql \
  opcache \
  zip \
  bcmath \
  bz2 \
  gd \
  json \
  mbstring \
  mcrypt \
  xml \
  xmlrpc

RUN echo "[Session]\n session.save_path = \"/var/lib/php/sessions\"" >> /usr/local/etc/php/php.ini
RUN echo "[Date]\n date.timezone = 'America/Sao_Paulo'" >> /usr/local/etc/php/php.ini

RUN mkdir -p /var/lib/php/sessions
RUN chmod 777 /var/lib/php/sessions

RUN cd /var/www/html/
