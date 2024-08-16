# Use PHP with Apache as the base image
FROM php:8.2-apache as web

# Install Additional System Dependencies
RUN apt-get update && \
    apt-get install -y --no-install-recommends \
    libzip-dev \
    libz-dev \
    libzip-dev \
    libjpeg-dev \
    libpng-dev \
    libfreetype6-dev \
    libssl-dev \
    libxml2-dev \
    libreadline-dev \
    unzip \
    supervisor

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Enable Apache mod_rewrite for URL rewriting
RUN a2enmod rewrite


#####################################
# PHP Extensions
#####################################
# Install the PHP shared memory driver
RUN pecl install APCu && \
    docker-php-ext-enable apcu

# Install the PHP bcmath extension
RUN docker-php-ext-install bcmath

# Install for image manipulation
RUN docker-php-ext-install exif

# Install the PHP graphics library
RUN docker-php-ext-configure gd \
    --with-freetype \
    --with-jpeg
RUN docker-php-ext-install gd

# Install the PHP intl extention
RUN docker-php-ext-install intl

# Install the PHP mysqli extention
RUN docker-php-ext-install mysqli && \
    docker-php-ext-enable mysqli

# Install the PHP opcache extention
RUN docker-php-ext-install opcache

# Install the PHP pcntl extention
RUN docker-php-ext-install pcntl

# Install the PHP pdo_mysql extention
RUN docker-php-ext-install pdo_mysql

# Install the PHP redis driver
RUN pecl install redis && \
    docker-php-ext-enable redis

# install XDebug but without enabling
RUN pecl install xdebug

# Install the PHP zip extention
RUN docker-php-ext-install zip

# Configure Apache DocumentRoot to point to Laravel's public directory
# and update Apache configuration files
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf


# Copy the application code
COPY . /var/www/html

# Set the working directory
WORKDIR /var/www/html

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install project dependencies
RUN COMPOSER_ALLOW_SUPERUSER=1 composer install

# Set permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache