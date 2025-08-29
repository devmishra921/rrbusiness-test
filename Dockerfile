FROM php:8.1-apache

# Install dependencies first
RUN apt-get update && apt-get install -y \
    libonig-dev \
    libzip-dev \
    libpng-dev \
    default-mysql-client \
    && docker-php-ext-install pdo pdo_mysql mysqli

# Copy project files
COPY . /var/www/html/

WORKDIR /var/www/html

EXPOSE 80

CMD ["apache2-foreground"]
