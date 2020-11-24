FROM php:7.4-apache

WORKDIR /var/www/html/

RUN requirements="git nano" \
    && apt-get update && apt-get install -y --no-install-recommends $requirements && rm -rf /var/lib/apt/lists/*
RUN yes | pecl install xdebug \
    && echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" > /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_enable=on" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_autostart=off" >> /usr/local/etc/php/conf.d/xdebug.ini

COPY --from=composer /usr/bin/composer /usr/bin/composer
ENV PATH="~/.composer/vendor/bin:./vendor/bin:${PATH}"
