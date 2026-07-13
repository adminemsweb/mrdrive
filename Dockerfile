FROM php:8.2-apache

RUN docker-php-ext-install pdo pdo_mysql mysqli
RUN a2enmod rewrite headers expires

ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

RUN sed -ri 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri 's!/var/www/!${APACHE_DOCUMENT_ROOT}/!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

COPY . /var/www/html/

RUN mkdir -p /var/www/html/public/uploads/documents /var/www/html/public/uploads/products \
    && chown -R www-data:www-data /var/www/html/public/uploads
