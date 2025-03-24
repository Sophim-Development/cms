# Use official PHP + Apache image
FROM php:8.2-apache

# Install PHP extensions
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Copy project files to Apache's web root
COPY . /var/www/html/

# Enable .htaccess and mod_rewrite if needed
RUN a2enmod rewrite

# Custom Apache config (optional, since you have apache-config.conf)
COPY apache-config.conf /etc/apache2/sites-available/000-default.conf