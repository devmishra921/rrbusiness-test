FROM php:8.1-apache

# Install MySQL driver
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Copy project files
COPY . /var/www/html/

# Apache document root set karna agar tumhara index.php kisi subfolder me ho
# WORKDIR /var/www/html/public

EXPOSE 80
