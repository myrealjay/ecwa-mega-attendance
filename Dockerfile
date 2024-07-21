FROM php:8.2-fpm

COPY composer.lock composer.json /var/www/html/

WORKDIR /var/www/html

RUN apt-get update -y && apt-get install -y \
    build-essential \
    zip \
    nano \
    unzip \
    git \
    curl \
    libonig-dev

#install extensions
RUN docker-php-ext-install pdo_mysql mbstring exif

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN groupadd -g 1000  www
RUN useradd -u 1000 -ms /bin/bash -g www www

COPY . /var/www/html

#copy existing application directory permisions
COPY --chown=www:www . /var/www/html

#vhange current user to www
USER www

#expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]

CMD composer install
CMD php artisan migrate
CMD php artisan db:seed
CMD php artisan serve --host=0.0.0.0