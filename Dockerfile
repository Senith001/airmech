FROM php:8.3-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    unzip \
    less \
    && rm -rf /var/lib/apt/lists/*

# Configure GD extension with JPEG and FreeType support
RUN docker-php-ext-configure gd --with-jpeg --with-freetype

# Install PHP extensions required for WordPress and WooCommerce
RUN docker-php-ext-install \
    mysqli \
    gd \
    zip \
    exif \
    opcache

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Allow .htaccess overrides by setting AllowOverride All for /var/www/html
RUN sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

# Optional: Add OPcache configuration for better performance
RUN echo "opcache.enable=1" >> /usr/local/etc/php/conf.d/opcache.ini && \
    echo "opcache.memory_consumption=128" >> /usr/local/etc/php/conf.d/opcache.ini && \
    echo "opcache.interned_strings_buffer=8" >> /usr/local/etc/php/conf.d/opcache.ini && \
    echo "opcache.max_accelerated_files=4000" >> /usr/local/etc/php/conf.d/opcache.ini && \
    echo "opcache.revalidate_freq=2" >> /usr/local/etc/php/conf.d/opcache.ini && \
    echo "opcache.fast_shutdown=1" >> /usr/local/etc/php/conf.d/opcache.ini

# Document root remains /var/www/html (default)
WORKDIR /var/www/html

# Expose port 80
EXPOSE 80