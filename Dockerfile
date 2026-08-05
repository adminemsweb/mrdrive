FROM node:22-alpine AS frontend

WORKDIR /app
COPY package.json package-lock.json vite.config.js ./
RUN npm ci
COPY resources ./resources
RUN npm run build

FROM php:8.2-apache

RUN apt-get update \
    && apt-get install -y --no-install-recommends libcurl4-openssl-dev \
    && docker-php-ext-install pdo pdo_mysql mysqli curl \
    && rm -rf /var/lib/apt/lists/*
RUN a2enmod rewrite headers expires

ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

RUN sed -ri 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri 's!/var/www/!${APACHE_DOCUMENT_ROOT}/!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

COPY . /var/www/html/
COPY --from=frontend /app/public/build /var/www/html/public/build

RUN mkdir -p /var/www/html/public/uploads/documents /var/www/html/public/uploads/products \
    && chown -R www-data:www-data /var/www/html/public/uploads
