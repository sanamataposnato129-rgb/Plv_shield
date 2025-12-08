# Multi-stage Dockerfile for Laravel 12 (PHP 8.2)
# Stages:
# 1) composer: install PHP dependencies
# 2) nodebuilder: build frontend assets with npm/vite
# 3) production: final image with php-fpm + nginx

######### Composer stage #########
FROM composer:2 AS composer
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader

######### Node build stage #########
FROM node:18 AS nodebuilder
WORKDIR /app
COPY package.json package-lock.json ./
RUN npm ci --no-audit --prefer-offline
COPY . .
RUN npm run build

######### Production stage #########
FROM php:8.2-fpm-alpine
ARG PUID=1000
ARG PGID=1000
WORKDIR /var/www/html

# System deps
RUN apk add --no-cache \
    nginx tzdata bash shadow sudo git libzip-dev libpng libpng-dev libjpeg-turbo-dev libwebp-dev freetype-dev zlib-dev libxml2-dev oniguruma-dev icu-dev ca-certificates curl unzip

# PHP extensions installation
RUN docker-php-ext-configure gd --with-jpeg --with-webp --with-freetype && \
    docker-php-ext-install pdo pdo_mysql gd zip mbstring xml bcmath intl

# Copy application files
COPY --from=composer /app/vendor /var/www/html/vendor
COPY --from=nodebuilder /app/public/build /var/www/html/public/build
COPY . /var/www/html

# Ensure permissions (may be adjusted for your host)
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache || true

# Nginx config
RUN mkdir -p /run/nginx
COPY ./docker/nginx/default.conf /etc/nginx/conf.d/default.conf

EXPOSE 80

# Start both php-fpm and nginx in foreground
CMD php-fpm -D && nginx -g "daemon off;"
