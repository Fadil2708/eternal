FROM php:8.3-fpm

RUN apt-get update && apt-get install -y \
    nginx \
    git \
    curl \
    zip \
    unzip \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libwebp-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libzstd-dev \
    liblz4-dev \
    nodejs \
    npm \
    && rm -rf /var/lib/apt/lists/*

# PHP extensions
RUN docker-php-ext-configure gd \
        --with-freetype \
        --with-jpeg \
        --with-webp \
    && docker-php-ext-install \
        pdo_mysql \
        mbstring \
        zip \
        exif \
        pcntl \
        bcmath \
        gd

# PHP upload configuration
RUN echo "upload_max_filesize=20M" > /usr/local/etc/php/conf.d/uploads.ini \
    && echo "post_max_size=25M" >> /usr/local/etc/php/conf.d/uploads.ini \
    && echo "max_file_uploads=20" >> /usr/local/etc/php/conf.d/uploads.ini \
    && echo "upload_tmp_dir=/tmp" >> /usr/local/etc/php/conf.d/uploads.ini

# Redis
RUN pecl install redis \
    && docker-php-ext-enable redis

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .

# Laravel dependencies + frontend build
RUN composer install --no-dev --optimize-autoloader \
    && npm install \
    && npm run build \
    && npm prune --production \
    && php artisan livewire:publish --assets

# Laravel permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 775 /var/www/html/bootstrap/cache

# Allow environment variables to be passed to PHP-FPM
RUN sed -i 's/clear_env = yes/clear_env = no/' /usr/local/etc/php-fpm.d/www.conf

# Nginx
COPY deploy/nginx.conf /etc/nginx/sites-enabled/default

# Startup
COPY startup.sh /startup.sh

RUN chmod +x /startup.sh

EXPOSE 8080

CMD ["/startup.sh"]