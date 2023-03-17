FROM php:7.4.3-apache

# Install PHP extensions
RUN apt-get update && \
    apt-get install -y libfreetype6-dev libjpeg62-turbo-dev libpng-dev && \
    docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install gd mysqli pdo pdo_mysql

# Copy custom php.ini
COPY php.ini /usr/local/etc/php/

# Create the uploads folder and set permissions
RUN mkdir -p /var/www/html/public/uploads && \
    chown -R www-data:www-data /var/www/html/public/uploads && \
    chmod 755 /var/www/html/public/uploads \

