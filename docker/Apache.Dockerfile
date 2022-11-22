FROM php:8.1.0-apache
RUN apt-get update
RUN apt-get install -y libpq-dev \
&& docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
&& docker-php-ext-install pgsql pdo_pgsql
ADD ./apache_conf/apache2.conf /etc/apache2/sites-available/000-default.conf
ADD ./apache_conf/php.ini /usr/local/etc/php/php.ini-development
ADD ./apache_conf/php.ini /usr/local/etc/php/php.ini-production
WORKDIR /var/www/laravel-docker
