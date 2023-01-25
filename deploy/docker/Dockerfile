FROM node:18.12-buster-slim as builder

WORKDIR /app

COPY . .

RUN yarn install

RUN yarn run production

# production environment
FROM php:8.2.0RC5-fpm-buster

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# Install system dependencies
RUN ln -f -s /usr/share/zoneinfo/America/Fortaleza /etc/localtime && \
    DEBIAN_FRONTEND=noninteractive \
    apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    nginx

# Install PHP extensions
RUN docker-php-ext-install intl \
    pcntl \
    pdo_mysql \
    mbstring \
    exif \
    bcmath \
    sqlite3

RUN apt-get clean && rm -rf /var/lib/apt/lists/*

WORKDIR /app

COPY --from=builder /app .

RUN cp /app/deploy/nginx/default /etc/nginx/sites-available/default && \
    chown -R www-data:www-data /app && \
    chmod -R 777 storage/ bootstrap/cache/

RUN rm -f composer.lock

RUN composer install

EXPOSE 80

CMD ["bash", "/app/deploy/entrypoint.sh"]
