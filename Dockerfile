# Use an official PHP image as the base image
FROM php:8.2-fpm

# Install required system packages and PHP extensions
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libxml2-dev \
    libzip-dev \
    libicu-dev \
    unzip \
    libpq-dev \
    libldap2-dev \
    && docker-php-ext-configure gd --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql pdo_pgsql pgsql xml zip intl ldap \
    && docker-php-ext-install pcntl

# Install Xdebug 3.x
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug pgsql

# Copy custom php.ini file into the container
COPY /docker/php/conf.d/custom-php.ini /usr/local/etc/php/conf.d/custom-php.ini

# Set the working directory in the container
WORKDIR /var/www/html

# Copy the composer files into the container
COPY composer.json composer.lock ./

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install project dependencies
RUN composer install --no-scripts

# Copy the rest of the application code into the container
COPY . .

# Set permissions for storage and bootstrap cache folders
RUN chown -R www-data:www-data storage bootstrap/cache

# Expose the container's port 9000 for PHP-FPM
EXPOSE 9000

# Start PHP-FPM
CMD ["php-fpm"]
