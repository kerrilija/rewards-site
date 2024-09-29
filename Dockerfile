# Use the official PHP-FPM image as the base image
FROM php:8.3-fpm

# Install dependencies
RUN apt-get update && apt-get install -y \
    curl \
    zip \
    unzip \
    git \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set working directory
WORKDIR /var/www/html

# Copy the current directory contents to the container
COPY . /var/www/html

# Run Composer to install dependencies
RUN composer install

# Install Doctrine DBAL
RUN composer require doctrine/dbal

# Expose the port that PHP-FPM will listen on
EXPOSE 9000

CMD ["php-fpm"]
