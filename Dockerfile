FROM php:8.2-fpm

WORKDIR /var/www/html/app

RUN apt-get update && apt-get install -y libzip-dev curl vim unzip

# Add and enable PHP-PDO
RUN docker-php-ext-install pdo pdo_mysql mysqli zip
RUN docker-php-ext-enable pdo_mysql zip

# Install xDebug
RUN pecl install xdebug-3.2.1 \
    && docker-php-ext-enable xdebug

# Install composer
COPY --from=composer/composer:latest-bin /composer /usr/bin/composer

COPY --chown=www-data:www-data docker/mysql/entrypoint.sh /etc/profile.d/entrypoint.sh
RUN chmod +x /etc/profile.d/entrypoint.sh
RUN /etc/profile.d/entrypoint.sh

RUN usermod -u 1000 www-data

COPY --chown=www-data:www-data . /usr/src/app

USER www-data

EXPOSE 9000

CMD ["php-fpm"]