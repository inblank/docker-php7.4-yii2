FROM inblank/php7.4-apache
COPY --chown=www-data ./src /var/www/
RUN curl "https://getcomposer.org/download/latest-stable/composer.phar" -o "/usr/bin/composer" && chmod 755 /usr/bin/composer 
RUN cd /var/www && composer install